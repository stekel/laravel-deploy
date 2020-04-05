# Laravel-Deploy

Helpful command for deploying a given repository to a remote machine

----

## Installation

`composer require stekel/laravel-deploy`

| Laravel Version | Laravel-Deploy Version |
| --- | --- |
| v5.x | v1.x |
| v6.x | v2.x |
| v7.x | v3.x |

Create the config file
`php artisan vendor:publish --provider="stekel\LaravelDeploy\Laravel\Providers\LaravelDeployServiceProvider"`

Create a site configuration class
```php
<?php

namespace App;

use stekel\LaravelDeploy\Site;

class SampleSite extends Site
{
    public function prod()
    {
        $this->ssh('192.168.1.100, admin, password, function ($connection) {
            $connection->command('git reset --hard');
            $connection->command('git pull');
            $connection->command('composer install --optimize-autoloader --no-dev');
            $connection->command('php artisan migrate');
            $connection->command('php artisan cache:clear');
            $connection->command('php artisan config:cache');
            $connection->command('php artisan route:cache');
            $connection->command('php artisan view:cache');
        });
    }
}
```

Reference that class in the config
```php
// ...   
    'sites' => [
        'sample-site' => \App\SampleSite::class,
    ],
// ... 
```

Reference the site/environment when deploying
```
// stekel:deploy {site} {environment}
stekel:deploy sample-site prod
```
