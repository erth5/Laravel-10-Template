# Dependencie Vaults

kind of problem | details |possible solution | deps: | #1 | #2
--- | --- | --- | --- | --- | ---
several role and permission systems | voyager use own perm. system | use only one | | Vojager | spatie_permissions
|deps only for development| contributer specifie using only local or debug |-||sail => docker Instance|vite_dev command => headless changes
 illuminate/console, illuminate/contracts, psr/log| use different versions|delete vendor and composer.lock and try install --with-dependecies --dev||<https://github.com/nunomaduro/larastan> apih laravel-route-list-web, wulfheart/laravel-actions-ide-helper
psr/simple-cache|default is psr/simple-cache:^3.0|use psr/simple-cache:^2.0||<https://ldaprecord.com> composer require psr/simple-cache:^2.0 directorytree/ldaprecord|<https://docs.laravel-excel.com/nova/1.x> composer require psr/simple-cache:^2.0 maatwebsite/laravel-nova-excel

## Voyager

- is build for version 8
- Model folder is set to app/ Instead of app/Models gesucht
- Migrations not changed by changing db over vojager

- Installation ohne Dummy Data schlägt fehl
- Erstellt storage-public LINK
- Manuelle Route
- Abhängigkeiten werden nicht automatisch hinzugefügt

## Horizon

need ext-pcntl * on windows, wich is not in php.ini
<!-- dusk scrennshot display wrong configuration | dusk run with own env. configuration |-| | config validator | laravel dusk | -->
