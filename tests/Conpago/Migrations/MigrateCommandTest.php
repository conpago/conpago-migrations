<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:56
	 */

	namespace Conpago\Migrations;

	class MigrateCommandTest extends \PHPUnit_Framework_TestCase {

		function testMigrateCommandReportsStart(){
			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');
			$migrateCommandPresenter->expects($this->once())->method('migrationStarted')->with($this->equalTo(0));

			$migrateCommand = new MigrateCommand([], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportsStartWithMigrationsCount(){
			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');
			$migrateCommandPresenter->expects($this->once())->method('migrationStarted')->with($this->equalTo(1));


			$migration = $this->getMock('Conpago\Migrations\Contract\IMigration');

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportsEnd(){
			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');
			$migrateCommandPresenter->expects($this->once())->method('migrationEnded');

			$migrateCommand = new MigrateCommand([], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportMigrationRun(){
			$migration = $this->getMock('Conpago\Migrations\Contract\IMigration');

			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');
			$migrateCommandPresenter->expects($this->once())->method('runningMigration')->with($this->equalTo(1), $this->equalTo(1));

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportAllMigrationsRun(){
			$migration = $this->getMock('Conpago\Migrations\Contract\IMigration');

			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');
			$migrateCommandPresenter->expects($this->exactly(2))->method('runningMigration')
				->withConsecutive(
					array($this->equalTo(1), $this->equalTo(2)),
					array($this->equalTo(2), $this->equalTo(2))
				);

			$migrateCommand = new MigrateCommand([$migration, $migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportRunsMigration(){
			$migration = $this->getMock('Conpago\Migrations\Contract\IMigration');
			$migration->expects($this->once())->method('up');

			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandRunsAllMigrations(){
			$migration = $this->getMock('Conpago\Migrations\Contract\IMigration');
			$migration->expects($this->once())->method('up');

			$migration2 = $this->getMock('Conpago\Migrations\Contract\IMigration');
			$migration2->expects($this->once())->method('up');

			$migrateCommandPresenter = $this->getMock('Conpago\Migrations\Contract\IMigrateCommandPresenter');

			$migrateCommand = new MigrateCommand([$migration, $migration2], $migrateCommandPresenter);
			$migrateCommand->execute();
		}
	}
