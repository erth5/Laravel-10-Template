<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DiskClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disk:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schafft Speicherplatz auf dem System';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('on_linux')) {
            $commands = [
                #'rm -rf bootstrap/cache/*',
                #'rm -rf storage/logs/*.log',
                #'composer clear-cache',
                #'npm cache clean --force',

                'apt clean',
                #'apt autoclean',
                #'apt autoremove --purge',
                #'rm -rf ~/.local/share/Trash/*',
                #'rm -rf /tmp/*',
                #'journalctl --vacuum-time=1d',
                #'find /var/log -type f -name "*.log" -exec truncate --size 0 {} \;',
                #'rm -rf ~/.cache/thumbnails/*',
                #'rm -rf ~/.cache/google-chrome',
                #'rm -rf ~/.cache/*',
                #'deborphan | xargs sudo apt-get -y remove --purge',
            ];
            $this->clear($commands);
        }

        if (config('on_windows')) {
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
            if (config('on_windows')) {
                $process = new Process(['cmd', '/c', $command]);
            } else {
                // Unix-basierter Befehl
                $process = new Process([$command]);
            }

            $process->run();

            if (!$process->isSuccessful()) {
                $this->error('Fehler beim Ausführen: ' . $command . "\nError Output: " . $process->getErrorOutput());
            } else {
                $this->info($process->getOutput());
            }
        }
    }
}
