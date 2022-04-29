<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Illuminate\Console\Command;

class GenerateTest extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new tester for module';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd('123');
    }
}
