<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateRoute extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:route';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a route for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'route';


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

        $output = new ConsoleOutput();
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:route command... </>");

        $module_name = $this->getModuleName();
        $pascal_case = $this->getPascalCase();
        $lower_kebab_case = $this->getLowerKebabCase();

        /**
         * generate view files
         */

        // generate index view
        $this->addRoute(
            "Routes/routes.stub",
            $replace_strings = [
                'name' => $lower_kebab_case,
                'class' => $pascal_case,
                'module' => $module_name,
            ]
        );

        $output->writeln("<fg=green>Route created.</> \n");
    }
}
