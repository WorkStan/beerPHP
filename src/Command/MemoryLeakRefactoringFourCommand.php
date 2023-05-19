<?php
declare(strict_types=1);
namespace App\Command;

use stdClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'memory:fourth-example')]
class MemoryLeakRefactoringFourCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bigArray = $this->readData();
        $this->handleData($bigArray);
        $output->writeln(sprintf('%.1f MiB', memory_get_peak_usage() / 1024 / 1024));
        return Command::SUCCESS;
    }

    private function readData(): array
    {
        $bigArray = [];
        for ($i = 0; $i < 1_000_000; $i++)
        {
            $bigArray[] = 'test' . $i;
        }

        return $bigArray;
    }

    private function handleData(array $data): void
    {
        foreach ($data as $dataItem) {
            // Do something
        }
    }
}