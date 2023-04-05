<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as SupportRequest;

// gettype($data) instanceof SupportRequest not supportet

/**
 * Class UtilsService.
 */
class UtilsService
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
    public function validateRequest($req, $validationRules)
    {
        $validator = Validator::make($req->all(), $validationRules);

        if ($validator->fails()) {
            return false;
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
    public function fillObject($object, $data)
    {
        if (! $this->databaseName) {
            $this->databaseName = strtolower(Str::plural(class_basename($object), 2));
            $this->tableColumnNames = $this->getDbColumnsWithoutBoolean($this->databaseName);
            $this->checkboxtableColumnNames = $this->getDbBooleanColumns($this->databaseName);
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
                Log::debug('the key '.$key.' with value '.$value.' not found in '.get_class($object));
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
                Log::debug('the key '.$key.' with value '.$value.' not found in '.get_class($object));
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
    public function fillObjectFromRequest($object, Request $req, $withNullValues = true)
    {
        $databaseName = strtolower(Str::plural(class_basename($object), 2));
        $tableColumnNames = $this->getDbColumnsWithoutBoolean($databaseName);
        $checkboxtableColumnNames = $this->getDbBooleanColumns($databaseName);

        Log::debug('fillObjectFromRequest action to Object: '.$object.'starts');

        if (isset($tableColumnNames)) {
            foreach ($tableColumnNames as $columnName) {
                if ($req->has($columnName)) {
                    if ($withNullValues || $req->get($columnName) != null) {
                        if ($object->{$columnName} != $req->{$columnName}) {
                            Log::debug('Update DB Column '.$columnName.
                            ' from '.$object->{$columnName}.
                            ' to '.$req->{$columnName});

                            $object->{$columnName} = $req->{$columnName};
                        }
                    }
                }
            }
        }

        if (isset($checkboxtableColumnNames)) {
            foreach ($checkboxtableColumnNames as $checkboxColumnName) {
                Log::debug('Update DB Checkbox Column '.$checkboxColumnName.
                            ' from '.$object->{$checkboxColumnName} ?? 'false'.
                            ' to '.$req->{$checkboxColumnName}) == 'false';

                /* Checkboxen geben Keys nur zurück, wenn sie angekreutzt wurden */
                $req->has($checkboxColumnName) ? $object->{$checkboxColumnName} = true : $object->{$checkboxColumnName} = false;
            }
        }

        return $object;
    }

    /**
     * Befüllt ein Eloquent Model mit Daten aus einem Array
     *
     * @param object Objekt Model, dessen Attribute gefüllt werden sollen
     * @param  array  $array mit Daten
     * @return object gefülltes Objekt
     */
    public function fillObjectFromArrayRecursiv($object, array $array)
    {
        $this->databaseName = strtolower(Str::plural(class_basename($object), 2));
        if (! $this->tableColumnNames) {
            $this->tableColumnNames = $this->getDbColumnsWithoutBoolean($this->databaseName);
        }
        if (! $this->checkboxtableColumnNames) {
            $this->checkboxtableColumnNames ?? $this->getDbBooleanColumns($this->databaseName);
        }

        foreach ($array as $key => $value) {
            if (is_string($value)) {
                if (in_array($key, $this->tableColumnNames)) {
                    $object->{$key} = $value;
                }
            }
        }

        return $object;
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
            if (! in_array($currentColumn, $columns)) {
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
            if (! in_array($column, $currentColumns)) {
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
            if (! in_array($column, $currentColumns)) {
                return false;
            }
        }
        foreach ($currentColumns as $currentColumn) {
            if (! in_array($currentColumn, $columns)) {
                return false;
            }
        }

        return true;
    }
}
