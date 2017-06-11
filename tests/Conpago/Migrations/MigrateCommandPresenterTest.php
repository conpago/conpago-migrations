<?php
namespace Conpago\Migrations;

use Conpago\Console\Contract\Presentation\IConsolePresenter;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class MigrateCommandPresenterTest extends TestCase
{
    /** @var MigrateCommandPresenter */
    private $migrateCommandPresenter;

    /** @var MockObject| IConsolePresenter */
    private $consolePresenterMock;

    public function setUp(): void
    {
        $this->consolePresenterMock = $this->createMock(IConsolePresenter::class);
        $this->migrateCommandPresenter = new MigrateCommandPresenter($this->consolePresenterMock);
    }

    public function testMigrationStarted()
    {
        $this->consolePresenterMock
            ->expects($this->once())
            ->method('write')
            ->with($this->equalTo("Running migrations (1)..."));

        $this->migrateCommandPresenter->migrationStarted(1);
    }

    public function testMigrationEnded()
    {
        $this->consolePresenterMock
            ->expects($this->once())
            ->method('write')
            ->with($this->equalTo("Running migrations done."));

        $this->migrateCommandPresenter->migrationEnded();
    }

    public function testRunningMigration()
    {
        $number = 1;
        $count = 1;
        $this->consolePresenterMock
            ->expects($this->once())
            ->method('write')
            ->with($this->equalTo("Running migration ".$number." of ". $count ."."));

        $this->migrateCommandPresenter->runningMigration($number, $count);
    }
}
