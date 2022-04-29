<?php

namespace Akw82\ModuleGenerator\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateMigration extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:migration';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'migration';


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model.'],
        ];
    }



    /**
     * if table does not exists
     * then run generated migration file
     * @param  string  $table
     * @param  string  $migration_file_name
     */
    protected function migrate(string $table, string $migration_file_name)
    {
        $output = new ConsoleOutput();

        // ignore if already migrated and show "Nothing to migrate" message.
        $check_migration = Schema::hasTable($table);

        if ($check_migration) {
            $output->writeln("<fg=green>Nothing to migrate. </> \n");
        } else {
            // run generated migration file
            $output->writeln("<fg=green>Migration created.</>");
            $output->writeln("<fg=green>Migrating: </><fg=yellow>" . $this->getDatePrefix() . '_' . $table . "</>");
            Artisan::call("migrate --path=/database/migrations/{$migration_file_name}");
            $output->writeln("<fg=green>Migrated: </><fg=yellow>" . $this->getDatePrefix() . '_' . $table . "</> \n");
        }
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $output = new ConsoleOutput();
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:migration command... </>");

        $main_table_name = $this->getPluralName();
        $log_table_name = $this->argument('name') . '_logs';
        $module_name = $this->getModuleName();
        $pascal_case = $this->getPascalCase();
        $lower_kebab_case = $this->getLowerKebabCase();

        $main_migration_file_name = $this->getMigrationFileName($main_table_name);
        $log_migration_file_name = $this->getMigrationFileName($log_table_name);


        /**
         * generate migration files
         */

        // main table
        $this->compile(
            "Models/migration.create.stub",
            database_path("migrations"),
            $main_migration_file_name,
            $replace_strings = [
                'table' => $main_table_name,
            ]
        );

        // log table
        $this->compile(
            "Models/migration-log.create.stub",
            database_path("migrations"),
            $log_migration_file_name,
            $replace_strings = [
                'table' => $log_table_name,
                'model' => $pascal_case,
            ]
        );

        $this->migrate($main_table_name, $main_migration_file_name);
        $this->migrate($log_table_name, $log_migration_file_name);

        $output->writeln("<fg=green>Migration created.</> \n");
    }
}
