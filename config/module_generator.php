<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Stub Directory
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the stubs directory.
    |
    */

    'stub_directory' => __DIR__ . '/../stubs/',


    /*
    |--------------------------------------------------------------------------
    | Navigation links file
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the navigation links file.
    |
    */

    'navigation_path' => resource_path('views/links.json'),



    /*
    |--------------------------------------------------------------------------
    | User permissions seeder path
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the user permissions seeder path.
    | Example: database_path('seeders/PermissionsSeeder.php')
    |
    */

    'user_permissions_seeder_path' => database_path('seeders/PermissionsSeeder.php'),
];
