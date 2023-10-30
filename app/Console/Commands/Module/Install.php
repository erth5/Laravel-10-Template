<?php

namespace App\Console\Commands\Module;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:install {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Implementiert diesem Laravel ein Modul';

    const SUCCESS = 0;
    const RUNTIME_FAULT = 1;
    const SYNTAX_FAULT = 2;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        $composerFileName = 'composer.json';

        $this->initializeComposer($name, $composerFileName);
        $this->updateComposerJson($name, $composerFileName);
        $this->executeComposerRequire($name);
    }
    protected function initializeComposer($name, $composerFileName)
    {
        if (file_exists(modules_path("$name/$composerFileName"))) {
            $this->info("modules/$name/composer.json existiert bereits, wird übersprungen.");
            return;
        }

        try {
            putenv('COMPOSER_INIT=1');
            exec("cd modules/$name && composer init", $output, $result);

            switch ($result) {
                case self::SUCCESS:
                    logger($output);
                    break;
                case self::RUNTIME_FAULT:
                case self::SYNTAX_FAULT:
                    logger()->warning(get_class($this) . ' Fault');
                    break;
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            logger()->error($e);
        }
    }

    protected function updateComposerJson($name, $composerFileName)
    {
        $composerContent = file_get_contents($composerFileName);
        $repository = [
            'type' => 'path',
            'url' => "modules/" . $name
        ];
        $composerData = json_decode($composerContent, true);
        $composerData['repositories'][$name] = $repository;
        $updatedComposerContent = json_encode($composerData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($composerFileName, $updatedComposerContent);

        $this->info("Der Inhalt wurde erfolgreich in die composer.json-Datei eingefügt.");
    }

    protected function executeComposerRequire($name)
    {
        $call = env("APP_DEBUG") ? "composer require hsc/$name:@dev" : "composer require hsc/$name";

        try {
            exec($call, $output, $result);

            switch ($result) {
                case self::SUCCESS:
                    $this->info(print_r($output, true));
                    break;
                case self::RUNTIME_FAULT:
                case self::SYNTAX_FAULT:
                    logger()->warning(get_class($this) . ' Fault');
                    $this->info(print_r($output, true));
                    break;
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
