<?php

namespace Tests\Template\Models;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModelTest extends TestCase
{
    //Access to debug true needed
    use DatabaseTransactions;

    //Schreibweiße von "factory" in Laravel 9
    //$mresp = Model::factory(Test::class)->create();
    /**
     * Teste Standard Datenbank Schema
     * @group schema
     * @return void
     */

    public function test_db_schema_user()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id', 'name', 'email', 'email_verified_at', 'password'
            ]),
            1
        );
    }

    /**
     * Teste, das Datenbank Schema von Person
     * @group schema
     * @return void
     */
    public function test_db_schema_people()
    {
        /**
         * Im Unit test nicht funktionsfähig
         * $this->seed(Debug::class);
         */
        $this->assertTrue(
            Schema::hasColumns('people', [
                'id', 'user_id', 'surname', 'last_name', 'username'
            ]),
            1
        );
    }

    /**
     * Teste, das Datenbank Schema von Image
     * @group schema
     * @return void
     */
    public function test_db_schema_image()
    {
        $this->assertTrue(
            Schema::hasColumns('images', [
                'id', 'name', 'path', 'person_id', 'upload_time', 'update_time', 'remove_time'
            ]),
            1
        );
    }

    /**
     * Teste alle Datenbanken auf existenz - Abfrage intern
     * @group schema
     * @return void
     */
    public function test_db_schema_standard_tables_exist()
    {
        $allDbNames = array('users',  'people', 'langs', 'images');
        // Mit foreach wird der Index des Array automatisch entfernt
        foreach ($allDbNames as $dbScheme) {
            if (Schema::hasTable($dbScheme)) {
                $this->assertTrue(true);
            } else {
                echo ("The Table Name: " . $dbScheme . " is not in the database");
                $this->assertFalse(true);
            }
        }
    }

    /** possible Refactor? */

    /**
     * Teste Vordergrund Datenbanken auf existenz, Abfrage Config
     * @group schema
     * @return void
     */
    public function test_db_schema_spatie_tables_exist()
    {
        if (env('SPATIE') == true) {
            $allDbNamesArray = Config::get('database.spatie');
            // dd($allDbNamesArray);
            foreach ($allDbNamesArray as $dbName) {
                if (Schema::hasTable($dbName)) {
                    $this->assertTrue(true);
                } else {
                    $this->assertFalse(true);
                }
            }
        }
        $this->assertFalse(false);
    }

    /**
     * Teste Hintergrund Datenbanken auf existenz, Abfrage durch eine Datei
     * @group schema
     * @return void
     */
    public function test_db_schema_background_exist_batch()
    {
        // https://code-boxx.com/php-read-file/
        // $allDbNames =  file("database/migrations/migration_list.txt", FILE_SKIP_EMPTY_LINES);

        if (file_exists("database/migrations/background_tables.txt")) {
            $allDbNamesArray = array();
            $allDbNames = fopen("database/migrations/background_tables.txt", 'r') or die('error reading file');
            while (!feof($allDbNames)) {
                $textperline = fgets($allDbNames);
                // echo ($textperline);
                array_push($allDbNamesArray, $textperline);
            }
            foreach ($allDbNamesArray as $dbScheme) {
                if (Schema::hasTable($textperline)) {
                    $this->assertTrue(true);
                } else {
                    $this->assertTrue($textperline);
                }
            }
            fclose($allDbNames);
        }
    }

    /**
     * Teste alle Models darauf, ob ein DatenbankSchema existiert
     * @group schema
     * @return void
     */
    public function test_db_schema_all_exist_by_model()
    {
        $modelDirectory = "app/Models";
        foreach (glob($modelDirectory . '/*.*') as $filePath) {
            // $FluentNotPossible = $filePath->substr(11)->substr(0, -4)->Str::lower()->Str::plural();
            $fileName = substr($filePath, 11);
            $fileNameWithoutEnding = substr($fileName, 0, -4);
            $fileNameWithoutEnding = Str::lower($fileNameWithoutEnding);
            $pluralFileNameWithoutEnding = Str::plural($fileNameWithoutEnding);

            // Name Konvention, Backup ohne Plural
            if (Schema::hasTable($pluralFileNameWithoutEnding) == false) {
                if (Schema::hasTable($fileNameWithoutEnding) == false) {
                    echo $fileName . " is the first foundet Model, which has no Name-Konvention Database Schema";
                    $this->assertFalse(true);
                }
            }
        }
        $this->assertTrue(true);
    }
}
