<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use \Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class GenerateContent extends Command
{


    /**
     * Get the plural name
     * Example: two_words
     * @return string
     */
    protected function getPluralName()
    {
        return Str::of($this->argument('name'))->plural();
    }



    /**
     * Get the module name
     * Example: two-word
     * @return string
     */
    protected function getLowerKebabCase()
    {
        return Str::of($this->argument('name'))->replace('_', '-')->lower();
    }



    /**
     * Get the module name
     * Example: two_word
     * @return string
     */
    protected function getLowerSnakeCase()
    {
        return Str::of($this->argument('name'))->replace('-', '_');
    }


    /**
     * Get the model name
     * Example: TwoWord
     * @return string
     */
    protected function getPascalCase()
    {
        return Str::of($this->argument('name'))->replace('_', ' ')->title()->replace(' ', '');
    }


    /**
     * Get the module name
     * Example: Two Word
     * @return string
     */
    protected function getModuleName()
    {
        return Str::of($this->argument('name'))->replace('_', ' ')->title();
    }


    /**
     * Fetch stub file and the destination file path.
     * @param  string  $file
     * @param  string  $type
     * @return array
     */
    protected function getFile(string $stub, string $module_path, string $file_name)
    {
        // create module view directory
        if (!is_dir($module_path)) mkdir($module_path, 0777, true);

        return [
            'stub' =>  config('module_generator.stub_directory') . $stub,
            'path' => $module_path . '/' . $file_name,
        ];
    }



    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }



    /**
     * Get the full name to the migration file.
     *
     * @param  string  $table
     * @param  string  $path
     * @return string
     */
    protected function getMigrationFileName($table)
    {
        return $this->getDatePrefix() . '_create_' . $table . '_table.php';
    }



    /**
     * Determine if the given path is a file.
     *
     * @param  string  $file
     * @return bool
     */
    public function isFile($file)
    {
        return is_file($file);
    }


    /**
     * Get contents of a file with shared access.
     *
     * @param  string  $path
     * @return string
     */
    public function sharedGet($path)
    {
        $contents = '';

        $handle = fopen($path, 'rb');

        if ($handle) {
            try {
                if (flock($handle, LOCK_SH)) {
                    clearstatcache(true, $path);

                    $contents = fread($handle, $this->size($path) ?: 1);

                    flock($handle, LOCK_UN);
                }
            } finally {
                fclose($handle);
            }
        }

        return $contents;
    }



    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @param  bool  $lock
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function get($path, $lock = false)
    {

        $output = new ConsoleOutput();

        if ($this->isFile($path)) {
            return $lock ? $this->sharedGet($path) : file_get_contents($path);
        }

        $output->writeln("<options=bold;fg=red>Stub file does not exist at path:</> " . $path);
    }



    /**
     * append content to given file
     *
     * @param  string  $file
     * @param  string  $search
     * @param  string  $replace
     * @return string
     */
    protected function appendContent(string $file, string $search, string $replace)
    {
        $contents = file_get_contents($file);

        $offset = strpos($contents, $search);

        if ($offset && !strpos($contents, $replace)) {
            $new_content = substr_replace($contents, $search . $replace, $offset, strlen($search));
            // save file
            file_put_contents($file, $new_content);
        }
    }





    /**
     * Populate data to given file
     *
     * @param  array  $replace_strings
     * @param  string  $file_content
     * @return string
     */
    protected function populateData(array $replace_strings, string $file_content)
    {
        // searching and replacing with the given names
        if ($replace_strings) {
            foreach ($replace_strings as $search => $replace) {
                $file_content = str_replace('{{ ' . $search . ' }}', $replace, $file_content);
            }
        }

        return $file_content;
    }



    /**
     * append data to route file
     *
     * @param  array  $replace_strings
     * @param  string  $file_content
     * @return string
     */
    protected function addRoute(string $stub, array $replace_strings)
    {

        // reading / opening stub file content
        $file_content = $this->get(config('module_generator.stub_directory') . $stub);

        $file_content = $this->populateData($replace_strings, $file_content);

        file_put_contents(base_path('routes/web.php'), $file_content, FILE_APPEND);

        $output = new ConsoleOutput();
        $output->writeln("<options=bold;fg=green>Route: </> " . $this->getLowerKebabCase());
    }



    /**
     * Fetch stub file and the destination file path.
     * @param  string  $file
     * @param  string  $type
     * @return array
     */
    protected function compile(string $stub, string $module_path, string $file_name, array $replace_strings = [])
    {

        $output = new ConsoleOutput();

        $file =  $this->getFile($stub, $module_path, $file_name);

        if (file_exists($file['path'])) {
            $output->writeln("<options=bold;fg=red>EXISTS:</> " . $file['path']);
        } else {

            if ($replace_strings) {

                // reading / opening stub file content
                $file_content = $this->get($file['stub']);

                if (!is_null($file_content)) {

                    $file_content = $this->populateData($replace_strings, $file_content);

                    $output->writeln("<options=bold;fg=green>" . $file_name . ":</> " . $file['path']);

                    // propagating the generated content
                    file_put_contents($file['path'], $file_content, FILE_APPEND);
                }
            }
        }
    }
}
