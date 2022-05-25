<?php

declare(strict_types=1);

namespace Bjercke\Command;

use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends DoctrineCommand
{
    /** @var string|null */
    protected static $defaultName = 'migrations:import';

    protected function configure(): void
    {
        $this
            ->setAliases(['import'])
            ->setDescription(
                'Imports a database dump.'
            )
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> imports a database dump.:
EOT
            );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migratorConfigurationFactory = $this->getDependencyFactory()->getConsoleInputMigratorConfigurationFactory();
        $migratorConfiguration = $migratorConfigurationFactory->getMigratorConfiguration($input);
        $connection = $this->getDependencyFactory()->getConnection();

        $databaseName = (string)$connection->getDatabase();
        $question = sprintf(
            'WARNING! You are about to execute a database dump import "%s" that could result in schema changes and data loss. Are you sure you wish to continue?',
            $databaseName === '' ? '<unnamed>' : $databaseName
        );
        if (!$migratorConfiguration->isDryRun() && !$this->canExecute($question, $input)) {
            $this->io->error('Import cancelled!');

            return 3;
        }

        // Get all files inside folder
        $folder = __DIR__ . '/../Dumps';
        $files = array_diff(scandir($folder), ['.', '..']);

        $count = 0;

        // Loop through files and execute sql if file is not empty
        foreach ($files as $file) {

            if (is_dir($folder . '/' . $file)) {
                continue;
            }

            // If file does not end with .sql or .gz, skip it
            if (!str_ends_with($file, '.sql') && !str_ends_with($file, '.gz')) {
                continue;
            }

            // If file is compressed, decompress it
            if (str_ends_with($file, '.gz')) {
                ob_start();
                readgzfile($folder . '/' . $file);
                $sql = ob_get_clean();
            } else {
                $sql = file_get_contents($folder . '/' . $file);
            }

            $connection->executeQuery(trim($sql));
            $count++;
        }

        $this->io->success(sprintf('%d queries executed.', $count));

        return 0;
    }
}