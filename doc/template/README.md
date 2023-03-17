# Laravel Debug Template

Template for Laravel Projects

MADE For Europe/German use

## Introduction

This Template should be used by copy some needed parts to extend your debug possibilitys and speed up development.

The next steps are choose a starter Template, like jetstream or breeze if you want one and build your prefered software-stack.

contact me, if one of your software-stack tools not working with this template. The incompatibles can you found [here](/doc/template/dependencie_vaults.md).

Jetstream should be configured with the permission. See this tutorial:
<https://geisi.dev/blog/combining-laravel-jetstream-with-spatie-permissions/>

email:
wi2z69k2w@relay.firefox.com

## using

run

```artisan
php artisan storage:link
```
(will automaticly run by jetstream installation)

copy env.example to .env,

generate your app-key

## Documentation

Overview about Relationships: [draw.io File](/doc/template/Relationship_Modell.drawio)

This Project use [following Packages](/doc/template/integrated.md)

## some stuff

[This bigger Projects](/doc/template/environment.md)  are not integrated

How to clear your [cache](/doc/template/cache.md) and [run tests](/doc/template/dusk%2C%20test.md)

[Artisan commands](/doc/template/artisans.md) there used in this template

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
