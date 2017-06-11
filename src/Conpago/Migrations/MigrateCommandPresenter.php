<?php
namespace Conpago\Migrations;

use Conpago\Console\Contract\Presentation\IConsolePresenter;
use Conpago\Migrations\Contract\IMigrateCommandPresenter;

class MigrateCommandPresenter implements IMigrateCommandPresenter
{
    /** @var IConsolePresenter */
    private $consolePresenter;

    public function __construct(IConsolePresenter $consolePresenter)
    {
        $this->consolePresenter = $consolePresenter;
    }

    public function migrationStarted(int $count): void
    {
        $this->consolePresenter->write("Running migrations (".$count.")...");
    }

    public function migrationEnded(): void
    {
        $this->consolePresenter->write("Running migrations done.");
    }

    public function runningMigration(int $number, int $count): void
    {
        $this->consolePresenter->write("Running migration ".$number." of ". $count .".");
    }
}
