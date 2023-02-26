# Artisans

## User

```terminal
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
php artisan make:controller UserController --resource
```

## Tag

```terminal
php artisan make:model Tag -a
```

## Debug

```terminal
php artisan make:controller DebugController
```

```terminal
php artisan migrate:fresh --seed
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=PersonSeeder
```

```terminal
php artisan migrate:status
php artisan migrate:reset
php artisan migrate:rollback --step=1
php artisan db:wipe --force
```

```terminal
php artisan vendor:publish
```

```terminal
php artisan session:table
```

```terminal
composer require laravel-lang/publisher laravel-lang/lang --dev
php artisan vendor:publish --provider="LaravelLang\Publisher\ServiceProvider"
```
