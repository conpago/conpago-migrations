<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 19.05.15
	 * Time: 23:23
	 */

	namespace Conpago\Migrations;


	class MigrateCommandPresenterTest extends \PHPUnit_Framework_TestCase {

		public function testMigrationStarted() {
			$count = 1;

			$consolePresenter = $this->getMock('Conpago\Console\Contract\Presentation\IConsolePresenter');
			$consolePresenter->expects($this->once())->method('write')->with($this->equalTo("Running migrations (".$count.")..."));

			$migrateCommandPresenter = new MigrateCommandPresenter($consolePresenter);
			$migrateCommandPresenter->migrationStarted($count);
		}

		public function testMigrationEnded() {
			$consolePresenter = $this->getMock('Conpago\Console\Contract\Presentation\IConsolePresenter');
			$consolePresenter->expects($this->any())->method('write')->with($this->equalTo("Running migrations done."));

			$migrateCommandPresenter = new MigrateCommandPresenter($consolePresenter);
			$migrateCommandPresenter->migrationEnded();
		}

		public function testRunningMigration() {
			$number = 1;
			$count = 1;
			$consolePresenter = $this->getMock('Conpago\Console\Contract\Presentation\IConsolePresenter');
			$consolePresenter->expects($this->any())->method('write')->with($this->equalTo("Running migration ".$number." of ". $count ."."));

			$migrateCommandPresenter = new MigrateCommandPresenter($consolePresenter);
			$migrateCommandPresenter->runningMigration($number, $count);
		}
	}
