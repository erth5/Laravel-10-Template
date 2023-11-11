<?php

namespace App\Console\Commands\Laravel;

use Illuminate\Console\Command;

class ConvertTextToConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:config {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Text Datei in eine Laravel Config Datei umwandeln. Zeilen werden als Schlüssel zurückgegeben.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');
        $inputFile = $path . '.md';
        $outputFile = $path . '.php';

        $inputHandle = fopen($inputFile, 'r');
        $outputHandle = fopen($outputFile, 'w');

        // Überprüfen, ob das Öffnen der Dateien erfolgreich war
        if ($inputHandle && $outputHandle) {

            /* Array Start  */
            fwrite($outputHandle, "<?php
            return [");

            // Zeilenweise durch die Eingabedatei iterieren
            while (($line = fgets($inputHandle)) !== false) {

                $modifiedLine = "'" . rtrim($line, PHP_EOL) . "',";

                fwrite($outputHandle, $modifiedLine);
            }

            /* Array schließen */
            fwrite($outputHandle, "];");

            // Dateien schließen
            fclose($inputHandle);
            fclose($outputHandle);

            echo "Die Datei wurde erfolgreich bearbeitet.";
        } else {
            echo "Fehler beim Öffnen der Dateien.";
        }
    }
}
