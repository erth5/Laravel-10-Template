# Artisans

## Eloquent

```terminal
php artisan make:model Image -a
php artisan make:model Lang -a
php artisan make:model Person -a
php artisan make:model Tag -a
```

## Eloquent Debug

```terminal
php artisan make:controller  Debug/DebugController
php artisan make:controller  Debug/ImageController --resource
php artisan make:controller  Debug/PersonController
php artisan make:controller  Debug/UserController
```

## User

```terminal
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
php artisan make:controller UserController --resource
php artisan db:seed --class=UserSeeder
```

## Helper

```terminal
php artisan make:controller Helper/LangController
php artisan make:controller Helper/PermissionAndRoleController
php artisan make:migration create_permission_tables
```

## Jobs

```terminal
php artisan queue:table
```

## Miscellaneous

```terminal
php artisan make:controller DebugController
php artisan make:service UtilService
php artisan make:pivot langs people
php artisan make:rule OddRule
php artisan make:middleware LanguageManager
```

## Action from Laravel Actions

```terminal
php artisan make:action AdjustPerson
```

## Database commands

```terminal
php artisan migrate:status
php artisan migrate:fresh --seed
php artisan migrate:rollback --step=1
php artisan migrate:reset
php artisan db:wipe --force
```

## auto by jetstream

```terminal
php artisan session:table
```

## Publisher

```terminal
php artisan vendor:publish
```

### Language

```terminal
composer require laravel-lang/publisher laravel-lang/lang --dev
php artisan vendor:publish --provider="LaravelLang\Publisher\ServiceProvider"
```
