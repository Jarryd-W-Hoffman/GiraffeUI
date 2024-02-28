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
    **/
    protected $signature = 'gui:install';

    /**
     * The console command description.
     *
     * @var string
    **/
    protected $description = 'Install GiraffeUI and its dependencies.';

    /**
     * The directory separator for the current OS.
     *
     * @var string
    **/
    protected $ds = DIRECTORY_SEPARATOR;

    /**
     * Execute the console command.
    **/
    public function handle()
    {
        $this->info("GiraffeUI Installer");
        $this->newline();
        $this->line("A sleek and minimilistic UI package designed to seamlessly integrate with the TALL stack.");
        $this->newline();

        // Install all required composer packages.
        installComposerPackages();

        // Install all required node modules.
        installNodeModules();

        // Yarn or Npm ?
        $packageManagerCommand = $this->askForPackageInstaller();


        // Setup Tailwind and Daisy
        $this->setupTailwindDaisy($packageManagerCommand);

        // Copy stubs if it is a brand-new project
        // $this->copyStubs($shouldInstallVolt);

        // Publish config
        $this->info("\nPublishing configuration...\n");
        Artisan::call('vendor:publish --force --tag giraffeui.config');

        // Clear view cache
        $this->info("\nClearing view cache...\n");
        Artisan::call('view:clear');

        $this->info("\n✅   Done! Run `yarn dev` or `npm run dev`");
    }

    
    /**
     * Install all required composer packages.
     *
     * This method installs required composer packages including:
     * - livewire/livewire
     * - livewire/volt
     * 
     * @return void
    **/
    public function installComposerPackages()
    {
        // Inform user about Livewire installation.
        $this->info("\nInstalling Laravel Livewire (livewire/livewire)...\n");

        // Create a process for installing Livewire.
        $livewireProcess = new Process(["composer", "require", "livewire/livewire"]);
        $this->runProcessWithOutput($livewireProcess);

        // Inform user about successful Livewire installation.
        $this->info("\nLaravel Livewire installed successfully!\n");

        // Prompt user for Livewire Volt installation preference.
        $installVolt = $this->choice(
            'Would you like to install Livewire Volt (livewire/volt)?',
            ['Yes', 'No'],
            $allowMultipleSelections = false
        );

        // Install Volt if user chooses to.
        if ($installVolt == 'Yes') {
            // Inform user about Livewire Volt installation.
            $this->info("\nInstalling Livewire Volt (livewire/volt)...\n");

            // Create a process for installing Livewire Volt.
            $voltProcess = new Process(["composer", "require", "livewire/volt"]);
            $this->runProcessWithOutput($voltProcess);

            // Inform user about successful Livewire Volt installation.
            $this->info("\Livewire Volt installed successfully!\n");

            // Inform user about Livewire Volt Service Provider installation.
            $this->info("\nInstalling Livewire Volt Service Provider...\n");

            // Create a process for running Volt installer.
            $voltInstallerProcess = new Process(["php", "artisan", "volt:install"]);
            $this->runProcessWithOutput($voltInstallerProcess);

            // Inform user about successful Livewire Volt Service Provider installation.
            $this->info("\Livewire Volt Service Provider installed successfully!\n");
        }
    }

    public function installNodeModules(string $packageManager) {
        

        $this->info("\nInstalling TailwindCSS...\n");

    }

    public function setupTailwindDaisy(string $packageManagerCommand)
    {
        $this->info("\nInstalling Tailwind...\n");

        $packageManagerCommand = explode(' ', $packageManagerCommand); // Split the command string into an array
        
        $process = new Process(array_merge($packageManagerCommand, ['install', '--save-dev', 'tailwindcss', 'postcss', 'autoprefixer']));
        $process->run(function (string $type, string $output) {
            echo $output;
        });

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

    /**
     * Prompt the user for their preferred package manager and return the selected option.
     *
     * @return string
    **/
    public function askForPackageInstaller(): string
    {
        // Determine the appropriate command to find executables based on the operating system.
        $os = PHP_OS;
        $findCommand = stripos($os, 'WIN') === 0 ? 'where' : 'which';

        // Array containing package manager options and their corresponding installation commands.
        $packageManagers = [
            'yarn' => 'yarn add -D',
            'npm' => 'npm install --save-dev',
        ];

        // Filter available package managers based on whether the corresponding executable is found.
        $options = array_filter(array_map(function ($manager) use ($findCommand) {
            $process = new Process([$findCommand, $manager]);
            $process->run();

            // If the output is not empty, consider the package manager as available.
            if (Str::of($process->getOutput())->isNotEmpty()) {
                return $manager;
            }

            return null;
        }, array_keys($packageManagers)));

        // If no package manager options are available, display an error message and exit.
        if (count($options) === 0) {
            $this->error("You need yarn or npm installed.");
            exit;
        }

        // Prompt user for package manager preference.
        return $this->choice(
            'Which package manager would you like to use?',
            $packageManagers,
            $allowMultipleSelections = false
        );
    }


    // private function copyFile(string $source, string $destination): void
    // {
    //     $source = str_replace('/', DIRECTORY_SEPARATOR, $source);
    //     $destination = str_replace('/', DIRECTORY_SEPARATOR, $destination);

    //     if (! copy($source, $destination)) {
    //         throw new RuntimeException("Failed to copy {$source} to {$destination}");
    //     }
    // }

    /**
     * Copy a file from the source to the destination.
     *
     * @param string $source      The source file path.
     * @param string $destination The destination file path.
     *
     * @return void
     *
     * @throws RuntimeException If the file copy fails.
    **/
    private function copyFile(string $source, string $destination): void
    {
        try {
            File::copy($source, $destination);
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to copy {$source} to {$destination}");
        }
    }

    /**
     * Run a process and display its output.
     *
     * @param Process $process
     * 
     * @return void
    **/
    private function runProcessWithOutput(Process $process)
    {
        $process->run(function (string $type, string $output) {
            echo $output;
        });
    }
}
