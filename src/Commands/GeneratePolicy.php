<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GeneratePolicy extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:policy';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a policy for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'policy';


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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if (config('module_generator.user_permissions_seeder_path')) {

            $output = new ConsoleOutput();
            $output->writeln("<options=bold,reverse;fg=green> Executing generate:navigation command... </>");

            // assigning names
            $lower_snake_case = $this->getLowerSnakeCase();
            $module_name_lower_case = $this->getModuleNameLowerCase();
            $model_name = $this->getPascalCase();

            /*
            * generate permissions
            */
            $replace_content = [
                'lower_snake_case' => $lower_snake_case,
                'module_name_lower_case' => $module_name_lower_case,
            ];

            // assigning path
            $seeder_path = config('module_generator.user_permissions_seeder_path');
            $stub_path = config('module_generator.stub_directory') . "seeds/add-permissions.stub";

            if (!file_exists($seeder_path)) {

                /*
                * generate user permissions seeder
                */
                $this->compile(
                    "seeds/permissions-seeder.stub",
                    database_path("seeders"),
                    "PermissionsSeeder.php",
                    $replace_strings = ['PermissionsSeeder' => 'PermissionsSeeder']
                );
            }

            // append content
            $contents = file_get_contents($stub_path);
            $populated_content = $this->populateData($replace_content, $contents);

            $this->appendContent($seeder_path, 'protected $data = [', $populated_content);

            /*
            * generate policy
            */
            $this->compile(
                "Models/policy.stub",
                app_path("Policies"),
                "{$model_name}Policy.php",
                $replace_strings = [
                    'model' => $model_name,
                    'lower_snake_case' => $lower_snake_case,
                ]
            );

            Artisan::call('db:seed PermissionsSeeder');
            $output->writeln("<fg=green>Database seeding completed successfully.</>");
            $output->writeln("<fg=green>Policy created.</> \n");
        }
    }
}
