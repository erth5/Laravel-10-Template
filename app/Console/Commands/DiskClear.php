<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class DiskClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disk:clear {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schafft Speicherplatz auf dem System';

    protected $useProcess;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->useProcess = strtolower($this->argument('type')) == 'process';
        if(!$this->isConfigCached()) {
            Artisan::call("optimize");
        }
        echo strpos(file_get_contents('/usr/lib/os-release'), 'Linux Mint') == true;
        echo file_exists('/usr/lib/os-release') && strpos(file_get_contents('/usr/lib/os-release'), 'Linux Mint') == true;

        if (str_contains(php_uname(), 'Linux')) {
            $commands = [
                #'rm -rf ./storage/logs/*.log',
                'rm -rf bootstrap/cache/*',
                'composer clear-cache',
                'npm cache clean --force',

                'apt clean',
                'apt autoclean',
                'apt autoremove --purge',
                'rm -rf ~/.local/share/Trash/*',
                'rm -rf /tmp/*',
                'journalctl --vacuum-time=1d',
                'find /var/log -type f -name "*.log" -exec truncate --size 0 {} \;',
                'rm -rf ~/.cache/thumbnails/*',
                'rm -rf ~/.cache/google-chrome',
                'rm -rf ~/.cache/*',
            ];
            $this->clear($commands);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $commands = [
                // 'del /q /f %TEMP%\*', // Löschen aller Dateien im TEMP-Verzeichnis
                // 'cleanmgr /sagerun:1', // Automatisierte Datenträgerbereinigung
                // 'powershell Clear-RecycleBin -Confirm:$false', // Leeren des Papierkorbs
                // 'del /q /f %SystemRoot%\Prefetch\*', // Löschen des Prefetch-Ordners
                // 'del /q /f %SystemRoot%\Temp\*', // Löschen des Windows Temp-Ordners
                // 'forfiles /p %SystemRoot%\Logs\CBS /s /m *.* /c "cmd /c del @file" /d -30', // Löschen alter Log-Dateien (älter als 30 Tage)
                // 'forfiles /p %SystemRoot%\Minidump /s /m *.* /c "cmd /c del @file" /d -30', // Löschen alter Minidump-Dateien (älter als 30 Tage)
                // 'dism /online /cleanup-image /startcomponentcleanup', // Bereinigen von Systemdateien
                // 'dism /online /cleanup-image /restorehealth', // Reparatur der Windows-Image-Dateien
                // 'wevtutil el | foreach-object {wevtutil cl "$_"}', // Löschen von Windows-Ereignisprotokollen
                // 'powershell Get-WindowsUpdateLog', // Windows Update-Protokolle generieren und bereinigen
            ];
            $this->clear($commands);
        }

        if (config('dockerized')) {
            $commands = [
                'docker system prune -a'
            ];
            $this->clear($commands);
        }
    }

    public function clear($commands)
    {
        foreach ($commands as $command) {

            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            
            if ($isWindows) {
                $commandParts = $this->useProcess ? ['cmd', '/c', $command] : $command;
            } else {
                $commandParts = $this->useProcess ? [$command] : $command;
            }
            
            if ($this->useProcess) {
                $process = new Process($commandParts); // unix basiert
                $process->run();
                if (!$process->isSuccessful()) {
                    $this->error('Fehler beim Ausführen: ' . $command . "\nError Output: " . $process->getErrorOutput());
                } else {
                    $this->info($process->getOutput());
                }

            } else {
                exec("sudo $commandParts", $output, $return);
                #info($output);
                echo $return;
            }
        }
    }

    public function isConfigCached()
    {
        $configCachePath = base_path('bootstrap/cache/config.php');
        return file_exists($configCachePath);
    }
}
