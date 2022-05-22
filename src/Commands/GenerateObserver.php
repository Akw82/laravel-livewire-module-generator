<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateObserver extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:observer';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a observer for the new module';



    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'observer';


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
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:observer command... </>");

        $model_name = $this->getPascalCase();

        // generate model observer
        $this->compile(
            "Models/observer.stub",
            app_path("Observers"),
            "{$model_name}Observer.php",
            $replace_strings = [
                'model' => $model_name,
                'modelVariable' => $model_name,
            ]
        );

        // registering observer service provider
        if (!file_exists(app_path("Providers/ObserverServiceProvider.php"))) {

            // generate observer service provider
            $this->compile(
                "Models/observer-service-provider.stub",
                app_path("Providers"),
                "ObserverServiceProvider.php",
                $replace_strings = []
            );

            sleep(6);
        }



        $data = [
            app_path("Providers/ObserverServiceProvider.php") => [
                [
                    "search" => "/* includes model and observers */" . PHP_EOL,
                    "content" => [
                        "use App\Observers\\" . $model_name . "Observer;" . PHP_EOL,
                        "use App\Models\\" . $model_name . ";" . PHP_EOL
                    ]
                ], [
                    "search" => "/* append model to observer */" . PHP_EOL,
                    "content" => [
                        "\t\t" . $model_name . "::observe(" . $model_name . "Observer::class);" . PHP_EOL,
                    ],
                ]
            ],
            config_path("app.php") => [
                [
                    "search" => "/*
         * Package Service Providers...
         */" . PHP_EOL,
                    "content" => [
                        "\t\t App\Providers\ObserverServiceProvider::class," . PHP_EOL,
                    ],
                ]
            ]
        ];


        foreach ($data as $path => $items) {
            foreach ($items as $item) {
                foreach ($item['content'] as $content) {
                    $this->appendContent($path, $item['search'], $content);
                }
            }
        }

        $output->writeln("<fg=green>Observer created.</> \n");
    }
}
