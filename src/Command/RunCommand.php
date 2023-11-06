<?php

declare(strict_types=1);

namespace TellMeWhen\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

#[AsCommand(name: 'run')]
class RunCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('shellCommand', InputArgument::REQUIRED, 'The command that will be run.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $shellCommand = $input->getArgument('shellCommand');

        $process = Process::fromShellCommandline($shellCommand);
        // print process output to the console
        $process->run(function ($type, $buffer) use ($output) {
            $output->writeln($buffer);
        });

        $process->mustRun();

        return Command::SUCCESS;
    }
}