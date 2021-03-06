<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:module {name : provide name of the module. }';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $output = new ConsoleOutput();

        // module name
        $name = $this->argument('name');

        // generate models files
        $this->call("generate:model", ['name' => $name]);

        // generate migrations files
        $this->call("generate:migration", ['name' => $name]);

        // generate observer files
        $this->call("generate:observer", ['name' => $name]);

        // generate view files
        $this->call("generate:view", ['name' => $name]);

        // generate routes
        $this->call("generate:route", ['name' => $name]);

        // generate policy
        $this->call("generate:policy", ['name' => $name]);

        // clear the cache
        $this->call("optimize");
        $this->call("route:clear");

        // generate navigation
        $this->call("generate:navigation", ['name' => $name]);

        $output->writeln("<options=bold,reverse;fg=green> NEW MODULE CREATED </> 🤙 ");
    }
}
