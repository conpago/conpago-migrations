<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:56
	 */

	namespace Conpago\Migrations;

	use Conpago\Migrations\Contract\IMigrateCommandPresenter;
    use Conpago\Migrations\Contract\IMigration;

    class MigrateCommandTest extends \PHPUnit_Framework_TestCase {

		function testMigrateCommandReportsStart(){
			$migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);
			$migrateCommandPresenter->expects($this->once())->method('migrationStarted')->with($this->equalTo(0));

			$migrateCommand = new MigrateCommand([], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportsStartWithMigrationsCount(){
            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);
			$migrateCommandPresenter->expects($this->once())->method('migrationStarted')->with($this->equalTo(1));


			$migration = $this->creteMigrationMock();

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportsEnd(){
            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);
			$migrateCommandPresenter->expects($this->once())->method('migrationEnded');

			$migrateCommand = new MigrateCommand([], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportMigrationRun(){
			$migration = $this->creteMigrationMock();

            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);
			$migrateCommandPresenter->expects($this->once())->method('runningMigration')->with($this->equalTo(1), $this->equalTo(1));

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportAllMigrationsRun(){
			$migration = $this->creteMigrationMock();

            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);
			$migrateCommandPresenter->expects($this->exactly(2))->method('runningMigration')
				->withConsecutive(
					array($this->equalTo(1), $this->equalTo(2)),
					array($this->equalTo(2), $this->equalTo(2))
				);

			$migrateCommand = new MigrateCommand([$migration, $migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandReportRunsMigration(){
			$migration = $this->creteMigrationMock();
			$migration->expects($this->once())->method('apply');

            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);

			$migrateCommand = new MigrateCommand([$migration], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

		function testMigrateCommandRunsAllMigrations(){
			$migration = $this->creteMigrationMock();
			$migration->expects($this->once())->method('apply');

			$migration2 = $this->creteMigrationMock();

            $migrateCommandPresenter = $this->createMock(IMigrateCommandPresenter::class);

			$migrateCommand = new MigrateCommand([$migration, $migration2], $migrateCommandPresenter);
			$migrateCommand->execute();
		}

        /**
         * @return \PHPUnit_Framework_MockObject_MockObject
         */
        public function creteMigrationMock()
        {
            return $this->createMock(IMigration::class);
        }
    }
