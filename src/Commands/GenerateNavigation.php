<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateNavigation extends GenerateContent
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:navigation';



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
     * initial json structure and append the link
     *
     * @param  callable  $callback
     * @return void
     */
    protected static function initializeAndAppend(callable $callback)
    {
        // initial json structure
        file_put_contents(config('module_generator.navigation_path'), '{"links": {}}' . PHP_EOL);
        // append the link
        self::updateNavigationMenu($callback);
    }



    /**
     * Update the "links.json" file.
     *
     * @param  callable  $callback
     * @return void
     */
    protected static function updateNavigationMenu(callable $callback)
    {

        $output = new ConsoleOutput();

        if (!file_exists(config('module_generator.navigation_path'))) {
            // create new links.json file
            touch(config('module_generator.navigation_path'));
            // initial json structure and append the link
            self::initializeAndAppend($callback);
        } else {

            $links = json_decode(file_get_contents(config('module_generator.navigation_path')), true);

            if (!$links) {
                // initial json structure and append the link
                self::initializeAndAppend($callback);
            } else if (!array_key_exists("links", $links)) {
                $output->writeln("<options=bold;fg=red>links.json has invalid format.</> ");
                /*
                * below mentioned are the sample valid format.
                * { "links": {} } 
                * or
                * { "links": {
                *  "name": "Sample",
                *  "route": "sample.index",
                *  "uri": "<a href=\"/http://sample.com/sample\">Sample</a>"
                * }
                */
            } else {

                $links["links"] = $callback(
                    array_key_exists("links", $links) ? $links["links"] : [],
                    "links"
                );

                file_put_contents(
                    config('module_generator.navigation_path'),
                    json_encode($links, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
                );

                $output->writeln("<fg=green>Navigation created.</> \n");
            }
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
        $output->writeln("<options=bold,reverse;fg=green> Executing generate:navigation command... </>");

        $module_name = $this->getModuleName();
        $route_name = $this->getLowerKebabCase();


        if (!Route::has($route_name . '.index')) {
            $output->writeln("<options=bold;fg=red>ROUTE NOT AVAILABLE:</> " . "/" . $route_name);
        } else {

            // generate navigation link
            $this->updateNavigationMenu(function ($links) use ($module_name, $route_name) {
                return [
                    "{$module_name}" => [
                        'name' => $module_name,
                        'route' => $route_name . '.index',
                        'uri' => '<a href="/' . route($route_name . '.index') . '">' . $module_name . '</a>'
                    ],
                ] + $links;
            });
        }
    }
}
