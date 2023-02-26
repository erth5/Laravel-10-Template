# dependencie vaults

kind of problem | details |possible solution | deps: | #1 | #2
--- | --- | --- | --- | --- | ---
several role and permission systems | voyager use own perm. system | use only one | libs, there use own permission system | Vojager | spatie_permissions
|deps only for development| contributer specifie using only local or debug |-||sail => docker Instance|vite_dev command => headless changes

## Voyager

- is build for version 8
- Model folder is set to app/ Instead of app/Models gesucht
- Migrations not changed by changing db over vojager

- Installation ohne Dummy Data schlägt fehl
- Erstellt storage-public LINK
- Manuelle Route
- Abhängigkeiten werden nicht automatisch hinzugefügt

## horizon

need ext-pcntl * under windows, wich is not in php.ini
<!-- dusk scrennshot display wrong configuration | dusk run with own env. configuration |-| | config validator | laravel dusk | -->
