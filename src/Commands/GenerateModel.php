<?php

namespace Akw82\ModuleGenerator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateModel extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:model';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'model';


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
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:model command... </>");

        $model_name = $this->getPascalCase();

        // generate model
        $this->compile(
            "Models/model.stub",
            app_path("Models"),
            "{$model_name}.php",
            $replace_strings = ['class' => $model_name]
        );

        // generate model log
        $this->compile(
            "Models/model-log.stub",
            app_path("Models"),
            "{$model_name}Log.php",
            $replace_strings = ['class' => $model_name]
        );

        $output->writeln("<fg=green>Model created.</> \n");
    }
}
