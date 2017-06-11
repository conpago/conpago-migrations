<?php
namespace Conpago\Migrations;

use Conpago\Migrations\Contract\IMigrateCommandPresenter;
use Conpago\Migrations\Contract\IMigration;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class MultipleMigrationsMigrateCommandTest extends TestCase
{
    /** @var  MockObject | IMigration */
    private $migration1Mock;

    /** @var  MockObject | IMigration */
    private $migration2Mock;

    /** @var MockObject | IMigrateCommandPresenter */
    private $migrateCommandPresenterMock;

    /** @var MigrateCommand */
    private $migrateCommand;

    public function setUp(): void
    {
        $this->migrateCommandPresenterMock = $this->createMock(IMigrateCommandPresenter::class);
        $this->migration1Mock = $this->createMock(IMigration::class);
        $this->migration2Mock = $this->createMock(IMigration::class);

        $this->migrateCommand = new MigrateCommand(
            [
                $this->migration1Mock,
                $this->migration2Mock
            ],
            $this->migrateCommandPresenterMock
        );
    }

    public function testMigrateCommandReportAllMigrationsRun()
    {
        $this->migrateCommandPresenterMock
            ->expects($this->exactly(2))
            ->method('runningMigration')
            ->withConsecutive(
                [$this->equalTo(1), $this->equalTo(2)],
                [$this->equalTo(2), $this->equalTo(2)]
            );

        $this->migrateCommand->execute();
    }

    public function testMigrateCommandRunsAllMigrations()
    {
        $this->migration1Mock->expects($this->once())->method('apply');
        $this->migration2Mock->expects($this->once())->method('apply');

        $this->migrateCommand->execute();
    }
}
