# Artisans

## Eloquent

```terminal
php artisan make:model Image -a
php artisan make:model Lang -a
php artisan make:model Person -a
php artisan make:model Tag -a
```

## User

```terminal
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
php artisan make:controller UserController --resource
php artisan db:seed --class=UserSeeder
```

## Permissions
```
php artisan make:controller PermissionAndRoleController
php artisan make:migration create_permission_tables
```

## Jobs

```
php artisan queue:table
```

## Miscellaneous

```terminal
php artisan make:controller DebugController
php artisan make:service UtilsService
php artisan make:pivot langs people
php artisan make:rule OddRule
php artisan make:middleware LanguageManager
```

## Database commands

```terminal
php artisan migrate:status
php artisan migrate:fresh --seed
php artisan migrate:rollback --step=1
php artisan migrate:reset
php artisan db:wipe --force
```

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
