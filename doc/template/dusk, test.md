# testing

<https://laravel.com/docs/10.x/dusk#main-content>

## url

.env url needs correct port, by localhost: localhost:8000

php artisan dusk:chrome-driver

php artisan dusk:chrome-driver --detect

## artisans

php artisan test --group=specification

php artisan test --group=data

php artisan test --filter=ExampleTest

php artisan test --filter=RuleTest
