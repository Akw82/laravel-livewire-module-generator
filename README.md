# laravel-livewire-module-generator

Create a module containing everything you want for a starter module.

1. Installing Jetstream livewire
   https://jetstream.laravel.com/2.x/installation.html#livewire

# Installing Jetstream:

You may use Composer to install Jetstream into your new Laravel project:

composer require laravel/jetstream

# Install Jetstream With Livewire:

php artisan jetstream:install livewire --teams

# Finalizing The Installation:

After installing Jetstream, you should install and build your NPM dependencies and migrate your database:

npm install
npm run dev
php artisan migrate

# Publish the Livewire stack's Blade components:

php artisan vendor:publish --tag=jetstream-views

# Install Package

composer require akw82/laravel-livewire-module-generator

# Publishing config:

php artisan vendor:publish --provider="Akw82\LaravelLivewireModuleGenerator\GenerateModuleServiceProvider" --tag="config"

# publishing all the required components:

php artisan vendor:publish --provider="Akw82\LaravelLivewireModuleGenerator\GenerateModuleServiceProvider" --tag="components"

# Spatie Installing:

Consult the Prerequisites page for important considerations regarding your User models!
This package publishes a config/permission.php file. If you already have a file by that name, you must rename or remove it.
You can install the package via composer:

composer require spatie/laravel-permission

# Publish the migration and the config/permission.php config file:

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Clear your config cache:

php artisan optimize:clear

# Run the migrations:

php artisan migrate

# Add the Spatie\Permission\Traits\HasRoles trait to your User model:

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
use HasRoles;

    // ...

}
