<?php
namespace Conpago\Migrations;

use Conpago\Console\Contract\ICommand;
use Conpago\Migrations\Contract\IMigrateCommandPresenter;
use Conpago\Migrations\Contract\IMigration;

class MigrateCommand implements ICommand
{
    /** @var IMigration[] */
    private $migrations;

    /** @var IMigrateCommandPresenter */
    protected $presenter;

    /**
     * @param IMigration[] $migrations
     * @param IMigrateCommandPresenter $presenter
     *
     * @inject Conpago\Migrations\Contract\IMigration $migrations
     * @inject Conpago\Migrations\Contract\IMigrateCommandPresenter $presenter
     */
    public function __construct(
        array $migrations,
        IMigrateCommandPresenter $presenter
    ) {

        $this->migrations = $migrations;
        $this->presenter = $presenter;
    }

    public function execute(): void
    {
        $this->presenter->migrationStarted(count($this->migrations));
        $index = 1;
        foreach ($this->migrations as $migration) {
            $this->runMigration($index++, $migration);
        }
        $this->presenter->migrationEnded();
    }

    /**
     * @param int $number
     * @param IMigration $migration
     */
    private function runMigration(int $number, IMigration $migration)
    {
        $this->presenter->runningMigration($number, count($this->migrations));
        $migration->apply();
    }
}
