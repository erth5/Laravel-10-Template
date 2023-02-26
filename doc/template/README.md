# Laravel Debug Template

Template for Laravel Projects

MADE For Europe/German use

## Introduction

This Template should be used by copy some needed parts to extend your debug possibilitys and speed up development.

The next steps are choose a starter Template, like jetstream or breeze if you want one and build your prefered software-stack.

contact me, if one of your software-stack tools not working with this template. The incompatibles can you found [here](/doc/debug/dependencie_vaults.md).

Jetstream should be configured with the permission. See this tutorial:
<https://geisi.dev/blog/combining-laravel-jetstream-with-spatie-permissions/>

email:
wi2z69k2w@relay.firefox.com

## using

run

```artisan
php artisan storage:link
```

copy env.example to .env, generate your app-key

## Documentation

Overview about Relationships: [draw.io File](/doc/debug/Relationship_Modell.drawio)

This Project use [following Packages](/doc/debug/integrated.md)

## some stuff

[This bigger Projects](/doc/debug/environment.md)  are not integrated

How to clear your [cache](/doc/debug/cache.md) and [run tests](/doc/debug/dusk%2C%20test.md)

Some [Artisan commands](/doc/debug/artisans.md)

---

## helper

### lang

search:
'item'
replace in view
{{ __('file.name') }}
replace in logic
__('file.name')

### wrong html using

placeholder='
class='

>>

<<

Bootstrap:

btn-yellow

## distriction

views/components No Routing

app\
Services only Procedurally

Http\
Controllers\Modules only Objective

- Object type
- Objective Instantiate
- Procedurally static

## Languages setttings

First Language English (US)
Second Language German (DE)
EN

- Fallback

DE

- Localisation
- Faker
