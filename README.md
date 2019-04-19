# Paraşüt.com v4 API Php and Laravel Client

## Install for Laravel

``
composer require yedincisenol/parasut
``

## For before laravel 5.5

in `config/app`

```
'providers' => [
        ...
        yedincisenol\Parasut\Laravel\LaravelServiceProvider::class
],

'aliases' => [
        ...
        'Parasut'       => yedincisenol\Parasut\Laravel\LaravelFacade::class
]
```

## Publish config file
```
php artisan vendor:publish --tag=parasut
```
