<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Console\Commands\DiskClear;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiskClearTest extends TestCase
{
    /**
     * Testet, ob nach Ausführung der DiskClear-Befehle Speicherplatz freigegeben wurde.
     */
    public function testDiskSpaceIsFreedAfterClearing()
    {
        // Messen des verfügbaren Speicherplatzes vor der Ausführung
        $initialFreeSpace = $this->getAvailableDiskSpace();

        // Ausführen der DiskClear-Befehle
        $diskClear = new DiskClear();
        $diskClear->handle();
        
        // Kurze Wartezeit, um sicherzustellen, dass alle Befehle abgeschlossen sind
        sleep(5);
        
        $this->assertTrue($this->isConfigCached(), 'Der Konfigurations-Cache existiert nicht.');

        // Messen des verfügbaren Speicherplatzes nach der Ausführung
        $finalFreeSpace = $this->getAvailableDiskSpace();

        // Überprüfen, ob der verfügbare Speicherplatz zugenommen hat
        $this->assertGreaterThan($initialFreeSpace, $finalFreeSpace, "Der verfügbare Speicherplatz hat nach dem Löschen nicht zugenommen.");
    }

    /**
     * Hilfsfunktion zur Messung des verfügbaren Speicherplatzes auf dem Disk.
     * 
     * @return int Verfügbaren Speicherplatz in Bytes
     */
    private function getAvailableDiskSpace()
    {
        // Implementierung zur Ermittlung des verfügbaren Speicherplatzes
        // Dies könnte ein Systemaufruf sein, der den freien Speicherplatz ermittelt
        return disk_free_space("/");
    }

    public function isConfigCached()
    {
    $configCachePath = base_path('bootstrap/cache/config.php');
    return file_exists($configCachePath);
    }

}
