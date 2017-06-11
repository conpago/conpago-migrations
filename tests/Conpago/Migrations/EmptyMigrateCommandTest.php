<?php
namespace Conpago\Migrations;

use Conpago\Migrations\Contract\IMigrateCommandPresenter;
use Conpago\Migrations\Contract\IMigration;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class EmptyMigrateCommandTest extends TestCase
{
    /** @var MockObject | IMigrateCommandPresenter */
    private $migrateCommandPresenterMock;

    /** @var MigrateCommand */
    private $migrateCommand;

    public function setUp(): void
    {
        $this->migrateCommandPresenterMock = $this->createMock(IMigrateCommandPresenter::class);
        $this->migrateCommand = new MigrateCommand([], $this->migrateCommandPresenterMock);
    }

    public function testMigrateCommandReportsStart()
    {
        $this->migrateCommandPresenterMock->expects($this->once())->method('migrationStarted')->with($this->equalTo(0));

        $this->migrateCommand->execute();
    }

    public function testMigrateCommandReportsEnd()
    {
        $this->migrateCommandPresenterMock->expects($this->once())->method('migrationEnded');

        $this->migrateCommand->execute();
    }
}
