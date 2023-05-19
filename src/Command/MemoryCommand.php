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
#[AsCommand(name: 'memory:first-example')]
class MemoryCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bigArray = [];
        $output->writeln("Used Allocated");
        for ($i = 0; $i < 200_000; $i++)
        {
            $bigArray[] = 'number' . $i;

            if (($i % 20_000) == 0)
            {
                $usedMem = round(memory_get_usage() / 1024);
                $allocMem = round(memory_get_usage(true) / 1024);

                $output->writeln("{$usedMem} {$allocMem}");
            }
        }
        return Command::SUCCESS;
    }
}