# laravel-livewire-module-generator

Create a module containing everything you want for a starter module.

# publishing config

php artisan vendor:publish --provider="Akw82\LaravelLivewireModuleGenerator\GenerateModuleServiceProvider" --tag="config"

# publishing all the required components.

php artisan vendor:publish --provider="Akw82\LaravelLivewireModuleGenerator\GenerateModuleServiceProvider" --tag="components"
