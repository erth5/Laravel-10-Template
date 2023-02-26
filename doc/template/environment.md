# Environment

## composer.json

```json
,
    "proxy": "http://127.0.0.1:8000"
```

## table: session

used by jetstream

## LDAP

<https://ldaprecord.com>
<https://ldaprecord.com/docs/laravel/v2/auth/sso>
composer.lock und vendor muss vor der Installation gelöscht werden, da Minor Update - kleine Laravel Updates Abhängigkeiten auf eine Version über ldap sperren

## GraphQL

<https://github.com/nuwave/lighthouse>

### Nicht unterstützt

Nohac/laravel-graphiql

### Installation

``` terminal
composer require tcg/voyager
php artisan voyager:install
php artisan voyager:install --with-dummy
```

``` php
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
use TCG\Voyager\Facades\Voyager;
```
