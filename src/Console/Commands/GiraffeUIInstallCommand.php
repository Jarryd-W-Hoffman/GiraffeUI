<?php

namespace JayAitch\GiraffeUI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use RuntimeException;

use function Laravel\Prompts\select;

class GiraffeUIInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gui:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install GiraffeUI and its dependencies.';

    protected $ds = DIRECTORY_SEPARATOR;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🦒 GiraffeUI Installer 🦒");

        // Install Volt ?
        $shouldInstallVolt = $this->askForVolt();

        // Yarn or Npm ?
        $packageManagerCommand = $this->askForPackageInstaller();

        // Install Livewire/Volt
        $this->installLivewire($shouldInstallVolt);

        // Setup Tailwind and Daisy
        $this->setupTailwindDaisy($packageManagerCommand);

        // Copy stubs if it is a brand-new project
        // $this->copyStubs($shouldInstallVolt);

        Artisan::call('vendor:publish --force --tag giraffeui.config');

        // Clear view cache
        Artisan::call('view:clear');

        $this->info("\n✅   Done! Run `yarn dev` or `npm run dev`");
    }

    public function installLivewire(string $shouldInstallVolt)
    {
        $this->info("\nInstalling Livewire...\n");

        $extra = $shouldInstallVolt == 'Yes'
            ? ' livewire/volt && php artisan volt:install'
            : '';

        Process::run("composer require livewire/livewire $extra", function (string $type, string $output) {
            echo $output;
        })->throw();
    }

    public function setupTailwindDaisy(string $packageManagerCommand)
    {
        /**
         * Install Tailwind
         */
        $this->info("\nInstalling Tailwind...\n");
        Process::run("$packageManagerCommand tailwindcss postcss autoprefixer", function (string $type, string $output) {
            echo $output;
        })->throw();

        /**
         * Setup app.css
         */

        $cssPath = base_path() . "{$this->ds}resources{$this->ds}css{$this->ds}app.css";
        $css = File::get($cssPath);

        if (! str($css)->contains('@tailwind')) {
            $stub = File::get(__DIR__ . "/../../../stubs/app.css");
            File::put($cssPath, str($css)->prepend($stub));
        }

        /**
         * Setup tailwind.config.js
         */

        $tailwindJsPath = base_path() . "{$this->ds}tailwind.config.js";

        if (! File::exists($tailwindJsPath)) {
            $this->copyFile(__DIR__ . "/../../../stubs/tailwind.config.js", "tailwind.config.js");
            $this->copyFile(__DIR__ . "/../../../stubs/postcss.config.js", "postcss.config.js");

            return;
        }

        /**
         * Setup Tailwind contents
         */
        $tailwindJs = File::get($tailwindJsPath);
        $originalContents = str($tailwindJs)->after('contents')->after('[')->before(']');

        if ($originalContents->contains('jayaitch/giraffeui')) {
            return;
        }

        $contents = $originalContents->squish()->trim()->remove(' ')->explode(',')->add('"./vendor/jayaitch/giraffeui/resources/**/*.blade.php"')->filter()->implode(', ');
        $contents = str($contents)->prepend("\n\t\t")->replace(',', ",\n\t\t")->append("\r\n\t");
        $contents = str($tailwindJs)->replace($originalContents, $contents);

        File::put($tailwindJsPath, $contents);
    }

    public function askForPackageInstaller(): string
    {
        $os = PHP_OS;
        $findCommand = stripos($os, 'WIN') === 0 ? 'where' : 'which';

        // $yarn = Process::run($findCommand . ' yarn')->output();
        $yarnProcess = new Process([$findCommand, 'yarn']);
        $yarnProcess->run();
        $yarn = $yarnProcess->getOutput();

        // $npm = Process::run($findCommand . ' npm')->output();
        $npmProcess = new Process([$findCommand, 'npm']);
        $npmProcess->run();
        $npm = $npmProcess->getOutput();

        $options = [];

        if (Str::of($yarn)->isNotEmpty()) {
            $options = array_merge($options, ['yarn add -D' => 'yarn']);
        }

        if (Str::of($npm)->isNotEmpty()) {
            $options = array_merge($options, ['npm install --save-dev' => 'npm']);
        }

        if (count($options) == 0) {
            $this->error("You need yarn or npm installed.");

            exit;
        }

        return select(
            label: 'Install with ...',
            options: $options
        );
    }

    /**
     * Also install Volt?
     */
    public function askForVolt(): string
    {
        return select(
            'Also install `livewire/volt` ?',
            ['Yes', 'No'],
            hint: 'No matter what is your choice, it always installs `livewire/livewire`'
        );
    }

    private function copyFile(string $source, string $destination): void
    {
        $source = str_replace('/', DIRECTORY_SEPARATOR, $source);
        $destination = str_replace('/', DIRECTORY_SEPARATOR, $destination);

        if (! copy($source, $destination)) {
            throw new RuntimeException("Failed to copy {$source} to {$destination}");
        }
    }
}
