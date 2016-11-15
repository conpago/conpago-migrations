<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:56
	 */

	namespace Conpago\Migrations;

	use Conpago\Console\Contract\ICommand;
	use Conpago\Migrations\Contract\IMigrateCommandPresenter;
	use Conpago\Migrations\Contract\IMigration;

	class MigrateCommand implements ICommand
	{
		/**
		 * @param IMigration[] $migrations
		 * @param IMigrateCommandPresenter $presenter
		 *
		 * @inject Conpago\Migrations\Contract\IMigration $migrations
		 * @inject Conpago\Migrations\Contract\IMigrateCommandPresenter $presenter
		 */
		function __construct(
			array $migrations,
			IMigrateCommandPresenter $presenter)
		{
			$this->migrations = $migrations;
			$this->presenter = $presenter;
		}

		function execute()
		{
			$this->presenter->migrationStarted(count($this->migrations));
			$i = 1;
			foreach($this->migrations as $migration) {
				$this->runMigration($i++, $migration);
			}
			$this->presenter->migrationEnded();
		}

		/**
		 * @var IMigration[]
		 */
		private $migrations;

		protected $presenter;

		/**
		 * @param int $number
		 * @param IMigration $migration
		 *
		 */
		private function runMigration($number, $migration ) {
			$this->presenter->runningMigration($number, count($this->migrations));
			$migration->apply();
		}
	}
