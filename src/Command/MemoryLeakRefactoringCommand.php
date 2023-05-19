<?php
declare(strict_types=1);
namespace App\Command;

use stdClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'memory:third-example')]
class MemoryLeakRefactoringCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $progressBar = new ProgressBar($output);
        $progressBar->start();
        $progressBar->setFormat('debug');

        $this->doSomething($progressBar);

        $progressBar->finish();
        $output->writeln('');
        return Command::SUCCESS;
    }

    private function doSomething(ProgressBar $progressBar): void
    {
        $bigArray = [];
        for ($i = 0; $i < 1_000_000; $i++)
        {
            $bigArray[] = 'test' . $i;
            $progressBar->advance();
        }
    }
}