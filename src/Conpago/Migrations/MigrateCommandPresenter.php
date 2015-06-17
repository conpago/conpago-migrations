<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 19.05.15
	 * Time: 23:23
	 */

	namespace Conpago\Migrations;


	use Conpago\Console\Contract\Presentation\IConsolePresenter;
	use Conpago\Migrations\Contract\IMigrateCommandPresenter;

	class MigrateCommandPresenter implements IMigrateCommandPresenter {

		/**
		 * @var IConsolePresenter
		 */
		private $consolePresenter;

		function __construct(IConsolePresenter $consolePresenter) {
			$this->consolePresenter = $consolePresenter;
		}

		public function migrationStarted( $count ) {
			$this->consolePresenter->write("Running migrations (".$count.")...");
		}

		public function migrationEnded() {
			$this->consolePresenter->write("Running migrations done.");
		}

		public function runningMigration( $number, $count ) {
			$this->consolePresenter->write("Running migration ".$number." of ". $count .".");
		}
	}
