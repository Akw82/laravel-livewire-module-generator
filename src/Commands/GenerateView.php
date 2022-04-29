<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateView extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:view';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a view for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'view';


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
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:view command... </>");

        $module_name = $this->getModuleName();
        $pascal_case = $this->getPascalCase();
        $lower_kebab_case = $this->getLowerKebabCase();

        /**
         * generate view files
         */

        // generate index view
        $this->compile(
            "Livewire/Module/livewire.index-view.stub",
            resource_path("views/livewire/{$lower_kebab_case}"),
            "index.blade.php",
            $replace_strings = [
                'module' => $module_name,
                'index' => $lower_kebab_case . '.index',
                'create' => $lower_kebab_case . '.create',
                'edit' => $lower_kebab_case . '.edit',
            ]
        );

        // generate create view
        $this->compile(
            "Livewire/Module/livewire.create-view.stub",
            resource_path("views/livewire/{$lower_kebab_case}"),
            "create.blade.php",
            $replace_strings = [
                'module' => $module_name,
                'index' => $lower_kebab_case . '.index',
            ]
        );





        /**
         * generate component class files
         */

        // generate data table delete action
        $this->compile(
            "Livewire/Module/DataTable/livewire.delete-action.stub",
            app_path("Http/Livewire/{$pascal_case}/DataTable"),
            "WithDeleteAction.php",
            $replace_string = [
                'model' => $pascal_case,
            ]
        );

        // generate data table delete action
        $this->compile(
            "Livewire/Module/DataTable/livewire.view-log-action.stub",
            app_path("Http/Livewire/{$pascal_case}/DataTable"),
            "WithViewLogAction.php",
            $replace_string = [
                'model' => $pascal_case,
            ]
        );

        // generate index component
        $this->compile(
            "Livewire/Module/livewire.index.stub",
            app_path("Http/Livewire/{$pascal_case}"),
            "Index.php",
            $replace_string = [
                'model' => $pascal_case,
                'view' => $lower_kebab_case,
            ]
        );

        // generate create component
        $this->compile(
            "Livewire/Module/livewire.create.stub",
            app_path("Http/Livewire/{$pascal_case}"),
            "Create.php",
            $replace_string = [
                'model' => $pascal_case,
                'view' => $lower_kebab_case,
            ]
        );

        $output->writeln("<fg=green>View created.</> \n");
    }
}
