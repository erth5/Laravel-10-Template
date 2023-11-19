<?php

namespace App\Services;

use Doctrine\Inflector\InflectorFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use RuntimeException;

// gettype($data) instanceof SupportRequest not supportet

/**
 * Class UtilService.
 */
class UtilService
{
    public ?array $tableColumnNames = null;

    public ?array $checkboxtableColumnNames = null;

    public string $databaseName = '';

    /**
     * prüft, ob das Objekt Request den angegebenen Regeln entspricht
     *
     * @param request req request
     * @param $validationRules associative array Array mit Validierungsregeln: https://laravel.com/docs/10.x/validation#manually-creating-validators
     * @param $validationErrorMessage string Fehlermeldung wenn Validierung mit Fehler abbricht
     * */
    public function validateRequest($req, $validationRules, $validationErrorMessage = '')
    {
        // Check if request and validation rules are set
        if (!$req || !$validationRules) {
            throw new InvalidArgumentException('Request and validation rules are required.');
        }

        $validator = Validator::make($req->all(), $validationRules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $validationErrorMessage);
        } else {
            return true;
        }
    }

    /**
     * Füllt ein Objekt mit gegebenen Daten
     *
     * @param object Objekt Model, dessen Attribute gefüllt werden sollen
     * @param mixed Daten mit den Schlüsselnamen und Werten des zu füllenden Objektes
     * @return object Objekt Model, mit gefüllten Attributen
     */
    public function fillObject($object, $data, $databaseName = null)
    {
        if (!$this->databaseName) {
            try {
                $this->databaseName = $databaseName ?? $this->getDbName(class_basename($object));

                $this->tableColumnNames = $this->getDbColumnsWithoutBoolean($this->databaseName);
                $this->checkboxtableColumnNames = $this->getDbBooleanColumns($this->databaseName);
            } catch (\Exception $e) {
                throw new RuntimeException('Error while setting database and column names');
            }
        }

        if ($data instanceof Model || is_object($data)) {
            foreach ($data->getAttributes() as $key => $value) {
                $object->{$key} = $value;
            }

            return $object;
        } elseif (gettype($data) instanceof Request) {
            $object = $this->fillObjectFromRequest($object, $data);

            return $object;
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $object = $this->fillObjectRecursiv($object, $value);

                continue;
            }

            if (is_scalar($value)) {
                if (in_array($key, $this->tableColumnNames) || in_array($key, $this->checkboxtableColumnNames)) {
                    $object->{$key} = $value;
                }
            } else {
                logger('the key ' . $key . ' with value ' . $value . ' not found in ' . get_class($object));
            }
        }

        return $object;
    }

    /**
     * Füllt ein Model mit Daten aus einem Array,
     * bei denen die Keys übereinstimmen
     *
     * @param [type] $object
     * @param [type] $data
     * @return object
     */
    public function fillObjectRecursiv($object, $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $object = $this->fillObjectRecursiv($object, $value);

                continue;
            }

            if (is_scalar($value)) {
                if (in_array($key, $this->tableColumnNames) || in_array($key, $this->checkboxtableColumnNames)) {
                    $object->{$key} = $value;
                }
            } else {
                logger('the key ' . $key . ' with value ' . $value . ' not found in ' . get_class($object));
            }
        }

        return $object;
    }

    /**
     * füllt ein Model mit den Request Daten (inklusive Checkboxen)
     *
     * @param object Objekt Model, dessen Attribute gefüllt werden sollen
     * @param array tableColumnNames array Array von attribut-Namen (string) aus dem Request, die im Objekt gefüllt werden sollen
     * @param array checkboxtableColumnNames array Array von attribut-Namen (string) die checkbox-werte (boolean-werte) repräsentieren, die aus dem Request, die im Objekt gefüllt werden sollen
     * @param request req request request Request oder SupportRequest
     * */
    public function fillObjectFromRequest($model, Request $req, $withNullValues = true)
    {
        $databaseName = $this->getDbName(class_basename($model));
        $tableColumnNames = $this->getDbColumnsWithoutBoolean($databaseName);
        $checkboxtableColumnNames = $this->getDbBooleanColumns($databaseName);

        if (isset($tableColumnNames)) {
            foreach ($tableColumnNames as $columnName) {
                if ($req->has($columnName)) {
                    if ($withNullValues || $req->get($columnName) != null) {
                        if ($model->{$columnName} != $req->{$columnName}) {
                            logger('Update DB Column ' . $columnName .
                                ' from ' . $model->{$columnName} .
                                ' to ' . $req->{$columnName});

                            $model->{$columnName} = $req->{$columnName};
                        }
                    }
                }
            }
        }

        logger("filled $model FromRequest");

        if (isset($checkboxtableColumnNames)) {
            foreach ($checkboxtableColumnNames as $checkboxColumnName) {
                logger('Update DB Checkbox Column ' . $checkboxColumnName .
                    ' from ' . $model->{$checkboxColumnName} ?? 'false' .
                    ' to ' . $req->{$checkboxColumnName}) == 'false';

                /* Checkboxen geben Keys nur zurück, wenn sie angekreutzt wurden */
                $req->has($checkboxColumnName) ? $model->{$checkboxColumnName} = true : $model->{$checkboxColumnName} = false;
            }
        }

        return $model;
    }

    /**
     * Befüllt ein Eloquent Model mit Daten aus einem Array
     *
     * @param Object $objekt Model, dessen Attribute gefüllt werden sollen
     * @param Array  $array mit Daten
     * @return Model gefülltes Model
     */
    public function fillObjectFromArrayRecursiv($model, array $array)
    {
        $this->databaseName = $this->getDbName(class_basename($model));
        if (!$this->tableColumnNames) {
            $this->tableColumnNames = $this->getDbColumnsWithoutBoolean($this->databaseName);
        }
        if (!$this->checkboxtableColumnNames) {
            $this->checkboxtableColumnNames ?? $this->getDbBooleanColumns($this->databaseName);
        }

        foreach ($array as $key => $value) {
            if (is_string($value)) {
                if (in_array($key, $this->tableColumnNames)) {
                    $model->{$key} = $value;
                }
            }
        }

        return $model;
    }

    /**
     * Gibt den Konvention Datenbankname eines Models zurück
     *
     * @param Model $model_name
     */
    public function getDbName($model)
    {
        $inflector = InflectorFactory::create()->build();
        return $inflector->pluralize($model);

        /* Methode ohne Wörterbuch */
        // Überprüfen, ob das Model-Argument leer ist
        if (empty($model)) {
            throw new InvalidArgumentException("Model name cannot be empty.");
        }

        // Überprüfen, ob das Model-Argument eine Zeichenkette ist
        if (!is_string($model)) {
            throw new InvalidArgumentException("Model name must be a string.");
        }

        // Konvertieren Sie den Model-Namen in Unterstrich-Notation
        $modelName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));

        // Entfernen Sie den Pluralisierungssuffix 's' vom Modellnamen, falls vorhanden
        // if (substr($modelName, -1) == 's') {
        //     $modelName = substr($modelName, 0, -1);
        // }

        // Ersetzen Sie alle nicht-ASCII-Zeichen durch Unterstriche, um ungültige Zeichen in der Datenbank zu vermeiden
        $modelName = preg_replace('/[^\x20-\x7E]/', '_', $modelName);

        // Ersetzen Sie alle Punkte durch Unterstriche
        $dbName = str_replace('.', '_', $modelName);

        // Überprüfen, ob der Datenbankname leer ist
        if (empty($dbName)) {
            throw new RuntimeException("Unable to create database name from the given model name.");
        }

        if (substr($dbName, -1) === "y") {
            return substr_replace($dbName, "ies", -1);
        }
        // Rückgabe des Datenbanknamens mit Pluralisierungssuffix
        return $dbName . 's';
    }

    private function getDbColumnsWithoutBoolean(string $database)
    {
        $tableColumns = [];
        $contents = Schema::getColumnListing($database);
        foreach ($contents as $content) {
            if (Schema::getColumnType($database, $content) != 'boolean') {
                $tableColumns[] = $content;
            }
        }

        return $tableColumns;
    }

    private function getDbBooleanColumns(string $database)
    {
        $tableColumns = [];
        $booleans = Schema::getColumnListing($database);
        foreach ($booleans as $maybeBool) {
            if (Schema::getColumnType($database, $maybeBool) == 'boolean') {
                $tableColumns[] = $maybeBool;
            }
        }

        return $tableColumns;
    }

    /**
     * Lasse prüfen, ob eine Datenbanktabelle, die angegebenen Spalten besitzt
     *
     * @param  string  $databaseName Name der Datenbank
     * @param  array  $columns erwartete Datenbank-Spalten-Namen
     * @return bool Alle Spalten existieren oder nicht
     */
    public function databaseHasColumns(string $databaseName, array $columns)
    {
        $currentColumns = Schema::getColumnListing($databaseName);
        foreach ($currentColumns as $currentColumn) {
            if (!in_array($currentColumn, $columns)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Lasse prüfen, ob die angegebenen Spalten in der Datenbank vorhanden sind
     *
     * @param  string  $databaseName Name der Datenbank
     * @param  array  $columns erwartete Datenbank-Spalten-Namen
     * @return bool Alle sind enthalten oder nicht
     */
    public function columnsInDatabase(string $databaseName, array $columns)
    {
        $currentColumns = Schema::getColumnListing($databaseName);
        foreach ($columns as $column) {
            if (!in_array($column, $currentColumns)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gibt alle ausfüllbaren keys eines Models zurück
     *
     * @return array $fillable
     */
    public function getFillableKeys(string $modelClass)
    {
        $objectInstance = new $modelClass();

        return $objectInstance->getFillable();
    }

    /**
     * Prüft, ob ein Model mit genau einer Reihe an Keys gefüllt werden kann
     *
     * @param  class-string  $model \Illuminate\Database\Eloquent\Model
     * @param  array  $columns erwartete Datenbank-Spalten-Namen
     * @return bool Beinhaltet genau diese Keys oder nicht
     */
    public function proofDatabaseFields(string $modelClass, array $columns)
    {
        $objectInstance = new $modelClass();
        $currentColumns = $objectInstance->getFillable();
        foreach ($columns as $column) {
            if (!in_array($column, $currentColumns)) {
                return false;
            }
        }
        foreach ($currentColumns as $currentColumn) {
            if (!in_array($currentColumn, $columns)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Überprüft, ob der aktuelle Code innerhalb eines Docker-Containers ausgeführt wird.
     *
     * @param string|null $cgroup Die `cgroups`-Hierarchie als Text. Standardmäßig wird die Datei `/proc/self/cgroup` verwendet.
     *
     * @return bool Gibt true zurück, wenn der Code innerhalb eines Docker-Containers ausgeführt wird, andernfalls false.
     */
    public function dockerized(?string $cgroup = null): bool
    {
        if (file_exists('/.dockerenv')) { // docker
            return true;
        }

        if (!$cgroup) {
            if (file_exists('/proc/self/cgroup')) {
                $cgroup = file_get_contents('/proc/self/cgroup'); // linux
            } else {
                return false; // windows
            }
        }

        return (bool) preg_match('/\bdocker\b/i', $cgroup);
    }

    /**
     * Ermittelt die Plattform eines PCs.
     *
     * @return string Die erkannte Plattform (z.B. x86 oder x64).
     */
    public function detectPlatform()
    {
        // Architektur abrufen
        $arch = php_uname('m');

        // Überprüfen, ob die Architektur ermittelt werden konnte
        if (!$arch) {
            return null;
        }

        // Plattformerkennung
        if (strpos($arch, 'x86') !== false) { // wenn x86-Architektur
            return "x86";
        } elseif (strpos($arch, 'x86_64') !== false || strpos($arch, 'amd64') !== false) { // wenn x64-Architektur
            return "x64";
        } else { // ansonsten unbekannt
            return null;
        }
    }

    /**
     * Ermittelt, ob es sich bei dem System um ein AMD- oder Intel-System handelt.
     *
     * @return string|null Die erkannte CPU-Architektur (AMD oder Intel), oder null, wenn die Architektur nicht erkannt werden konnte.
     */
    public function detectCpuArchitecture()
    {
        // Prozessorname abrufen
        $processor_name = php_uname('p');

        // Überprüfen, ob der Prozessorname ermittelt werden konnte
        if (!$processor_name) {
            return null;
        }

        // CPU-Architektur erkennen
        if (stripos($processor_name, 'AMD') !== false) { // Wenn es sich um ein AMD-System handelt
            return "AMD";
        } elseif (stripos($processor_name, 'Intel') !== false) { // Wenn es sich um ein Intel-System handelt
            return "Intel";
        } else { // Ansonsten unbekannt
            return null;
        }
    }

    public function getOwnMacAddress()
    {
        $output = null;
        $retval = null;

        // Linux
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            exec("ifconfig -a | grep -o -E '([[:xdigit:]]{1,2}[:-]){5}[[:xdigit:]]{1,2}'", $output, $retval);
        } else {
            // Windows
            exec("getmac", $output, $retval);
        }

        if ($retval == 0) {
            echo "MAC-Adressen gefunden: ";
            return $output;
        } else {
            echo "Fehler beim Abrufen der MAC-Adresse.";
            return null;
        }
    }

    public function getSystemPackageManger()
    {
        if (strtolower(php_uname()) == 'windows') {
            return 'choco'; // winget
        }

        if (strtolower(php_uname('s')) == 'darwin') {
            return 'brew'; // port
        }

        if (strtolower(php_uname()) == 'linux') {
            $packageManagers = ['apt', 'yum', 'dnf', 'zypper', 'pacman'];

            foreach ($packageManagers as $manager) {
                $output = null;
                $retval = null;

                exec("which $manager 2>&1", $output, $retval);

                if ($retval === 0) {
                    return $manager;
                }
            }
        }
        return;
    }

    public function getSystemPackageMangers()
    {
        $managers = [];

        if (stripos(php_uname(), 'Windows') !== false) {
            exec("where choco 2>nul", $output, $retval);
            $retval === 0 ? $managers[] = "choco" : null;
            exec("where winget 2>nul", $output, $retval);
            $retval === 0 ? $managers[] = "winget" : null;
            return $managers;
        }

        if (stripos(php_uname('s'), 'Darwin') !== false) {
            exec("which brew", $output, $retval);
            $retval === 0 ? $managers[] = "brew" : null;
            exec("which port", $output, $retval);
            $retval === 0 ? $managers[] = "port" : null;
            return $managers;
        }

        if (stripos(php_uname(), 'Linux') !== false) {
            $packageManagers = ['apt', 'yum', 'dnf', 'zypper', 'pacman'];
            foreach ($packageManagers as $manager) {
                $output = null;
                $retval = null;

                exec("which $manager 2>&1", $output, $retval);

                if ($retval === 0) {
                    $managers[] = $manager;
                }
            }
            return $managers;
        }
        return;
    }
    public function getOwnProtocol()
    {
        if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
            $scheme = 'https';
        } else {
            $scheme = 'http';
        }
        return $scheme;
    }


    public function formDateFromArray($array)
    {
        if ($array === null) {
            return null;
        }

        if (!is_array($array) || (count($array) !== 1 && count($array) < 6)) {
            throw new InvalidArgumentException("Das Array hat nicht die erforderliche Anzahl an Elementen.");
        }

        if (is_array($array) && count($array) === 1) {
            try {
                return Carbon::parse($array[0]);
            } catch (\Exception $e) {
                throw new InvalidArgumentException("Ungültiges Datum oder Zeit.");
            }
        }

        $dates = [
            'year' => $array[0],
            'month' => $array[1],
            'day' => $array[2],
        ];
        foreach ($dates as $part => $value) {
            if (!isset($value) || !is_numeric($value)) {
                throw new InvalidArgumentException("Der Teil '{$part}' ist nicht gesetzt oder nicht numerisch.");
            }
        }

        $times = [
            'hour' => isset($array[3]) ? $array[3] : null,
            'minute' => isset($array[4]) ? $array[4] : null,
            'second' => isset($array[5]) ? $array[5] : null,
        ];


        try {
            return Carbon::create($dates['year'], $dates['month'], $dates['day'], $times['hour'], $times['minute'], $times['second']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException("Ungültiges Datum oder Zeit.");
        }
    }

}
