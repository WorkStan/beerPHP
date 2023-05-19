<?php
declare(strict_types=1);
namespace App\Command;

use stdClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'memory:symlink-example')]
class SymlinkMemoryLeakCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        gc_disable();
        for ($i = 1; $i < 1_000_000; $i++) {
            $firstObject = new stdClass();
            $firstObject->field = $firstObject;
            unset($firstObject);
            if($i % 50_000 === 0) {
                gc_collect_cycles();
            }
        }
        $output->writeln(sprintf('%.1f MiB', memory_get_peak_usage() / 1024 / 1024));
        return Command::SUCCESS;
    }
}