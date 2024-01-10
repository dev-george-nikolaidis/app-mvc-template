<?php

declare(strict_types=1);

namespace Src\core;

use Src\core\DatabaseMigration;

class MigrationCLI
{
    private DatabaseMigration $migrator;

    public function __construct(DatabaseMigration $migrator)
    {
        $this->migrator = $migrator;
    }

    public function run(): void
    {
        global $argv;

        if (isset($argv) && count($argv) >= 2) {
            $command = $argv[1];

            switch ($command) {
                case 'migrate':
                    $this->migrate();
                    break;

                case 'rollback':
                    $this->rollback();
                    break;

                case 'help':
                    $this->printHelp();
                    break;

                default:
                    echo "Unknown command: $command\n";
                    $this->printHelp();
                    exit(1);
            }
        }
    }
    private function migrate(): void
    {
        // Implement logic to run migrations
        echo "Running migrations...\n";
        // Example: $this->migrator->createTable(...);

        echo "Migrations completed.\n";
    }

    private function rollback(): void
    {
        // Implement logic to rollback migrations
        echo "Rolling back migrations...\n";
        // Example: $this->migrator->dropTable(...);

        echo "Rollback completed.\n";
    }

    private function printHelp(): void
    {
        echo "Usage: php migration.php [command]\n";
        echo "Commands:\n";
        echo "  migrate    Run database migrations\n";
        echo "  rollback   Rollback the last database migration\n";
        echo "  help       Show this help message\n";
    }

}
