<?php
namespace Conpago\Migrations;

use Conpago\Migrations\Contract\IMigrateCommandPresenter;
use Conpago\Migrations\Contract\IMigration;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class OneMigrationMigrateCommandTest extends TestCase
{
    /** @var  MockObject | IMigration */
    private $migrationMock;

    /** @var MockObject | IMigrateCommandPresenter */
    private $migrateCommandPresenterMock;

    /** @var MigrateCommand */
    private $migrateCommand;

    public function setUp(): void
    {
        $this->migrateCommandPresenterMock = $this->createMock(IMigrateCommandPresenter::class);

        $this->migrationMock = $this->createMock(IMigration::class);

        $this->migrateCommand = new MigrateCommand([$this->migrationMock], $this->migrateCommandPresenterMock);
    }

    public function testMigrateCommandReportsStartWithMigrationsCount()
    {
        $this->migrateCommandPresenterMock
            ->expects($this->once())
            ->method('migrationStarted')
            ->with($this->equalTo(1));

        $this->migrateCommand->execute();
    }

    public function testMigrateCommandReportMigrationRun()
    {
        $this->migrateCommandPresenterMock
            ->expects($this->once())
            ->method('runningMigration')
            ->with($this->equalTo(1), $this->equalTo(1));

        $this->migrateCommand->execute();
    }

    public function testMigrateCommandReportRunsMigration()
    {
        $this->migrationMock->expects($this->once())->method('apply');

        $this->migrateCommand->execute();
    }
}
