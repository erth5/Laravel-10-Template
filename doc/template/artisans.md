# Artisans

```terminal
php artisan make:model Helper/Tag -a
php artisan make:controller Helper/TagController --resource
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
