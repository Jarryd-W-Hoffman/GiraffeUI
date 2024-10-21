<?php

namespace JayAitch\GiraffeUI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;

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
     * The filesystem instance.
     *
     * @var Filesystem
     **/
    protected Filesystem $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     **/
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     **/
    public function handle()
    {
        // Display the welcome message.
        $this->info("GiraffeUI Installer");
        $this->newline();
        $this->line("A sleek and minimilistic UI package designed to seamlessly integrate with the TALL stack.");
        $this->newline();

        // Install all required composer packages.
        $this->installComposerPackages();

        // Install all required node modules.
        $this->installNodeModules();

        // Install the package stubs.
        $this->installStubs();

        // Publish config file to allow user to customize the package.
        $this->info("\nPublishing configuration...");
        Artisan::call('vendor:publish --force --tag=giraffeui.config');


        // Clear view cache to ensure the new components are available.
        $this->info("Clearing view cache...\n");
        Artisan::call('view:clear');

        // Inform user about successful installation.
        $this->info("\nYou're all set! You can now start building your application with GiraffeUI.\n");
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

    /**
     * Install all required node modules.
     *
     * This method installs required node modules including:
     * - tailwindcss
     * 
     * @return void
     **/
    public function installNodeModules()
    {
        // Configure package manager based on the project.
        $packageManager = $this->configurePackageManager();

        // Inform the user about the installation process.
        $this->info("\nInstalling TailwindCSS...\n");

        // Split the package manager string into an array.
        $packageManager = explode(' ', $packageManager);

        // Create a process for installing tailwindCSS.
        $process = new Process(array_merge($packageManager, ['install', '--save-dev', 'tailwindcss', 'postcss', 'autoprefixer']));
        $this->runProcessWithOutput($process);

        // Update the project's CSS file with TailwindCSS if not already included.
        $cssPath = base_path() . "{$this->ds}resources{$this->ds}css{$this->ds}app.css";
        $css = File::get($cssPath);

        if (! str($css)->contains('@tailwind')) {
            $stub = File::get(__DIR__ . "/../../../stubs/app.css");
            File::put($cssPath, str($css)->prepend($stub));
        }

        // Set paths for Tailwind configuration and related files.
        $tailwindJsPath = base_path() . "{$this->ds}tailwind.config.js";

        // Check if Tailwind configuration file exists; if not, copy stubs.
        if (! File::exists($tailwindJsPath)) {

            $this->copyFile(__DIR__ . "/../../../stubs/postcss.config.js", "postcss.config.js");

            return;
        }

        $this->copyFile(__DIR__ . "/../../../stubs/tailwind.config.js", "tailwind.config.js");

        // // Update Tailwind configuration to include GiraffeUI paths.
        // //
        // // Todo: Add dark mode configuration.
        // //
        // $tailwindJs = File::get($tailwindJsPath);
        // $originalContents = str($tailwindJs)->after('contents')->after('[')->before(']');

        // // Check if GiraffeUI paths are already present; if yes, return.
        // if ($originalContents->contains('jayaitch/giraffeui')) {
        //     return;
        // }

        // // "./vendor/jayaitch/giraffeui/src/Components/*.php",
        // // "./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php",

        // // Add GiraffeUI paths to Tailwind configuration.
        // $contents = $originalContents->squish()->trim()->remove(' ')->explode(',')->add('"./vendor/jayaitch/giraffeui/src/resources/**/*.blade.php"')->filter()->implode(', ');
        // $contents = str($contents)->prepend("\n\t\t")->replace(',', ",\n\t\t")->append("\r\n\t");
        // $contents = str($tailwindJs)->replace($originalContents, $contents);

        // // Update the Tailwind configuration file.
        // File::put($tailwindJsPath, $contents);

        // Inform the user about the successful installation.
        $this->info("\nTailwindCSS installed successfully!\n");
    }

    /**
     * Prompt the user for their preferred package manager and return the selected option.
     *
     * @return string
     **/
    public function configurePackageManager(): string
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
            $this->error("No package manager found. Please install either Yarn or NPM to continue.");
            exit;
        }

        // Prompt user for package manager preference.
        return $this->choice(
            'Which package manager would you like to use?',
            $packageManagers,
            $allowMultipleSelections = false
        );
    }

    /**
     * Install the package stubs.
     * 
     * Check if the app.blade.php file already exists and prompt the user to overwrite, skip or rename.
     * 
     * @return void
     **/
    public function installStubs(): void
    {
        // Inform the user about the installation process.
        $this->info("\nInstalling GiraffeUI stubs...\n");

        // Define the path to the layouts directory within the project's resources.
        $layoutsPath = "resources{$this->ds}views{$this->ds}layouts";

        // Ensure that the layouts directory exists, create if not.
        $this->createDirectory($layoutsPath);

        // Define the path to the app.blade.php file.
        $appBladePath = "{$layoutsPath}{$this->ds}app.blade.php";

        // Check if the app.blade.php file already exists.
        if ($this->filesystem->exists($appBladePath)) {
            // Prompt the user for action: overwrite, skip, or rename.
            $choice = $this->choice(
                "The app.blade.php file already exists. What would you like to do?",
                ['Overwrite', 'Skip', 'Rename']
            );

            if ($choice === 'Overwrite') {
                // Delete the existing file to overwrite.
                $this->filesystem->delete($appBladePath);
                $this->info("The existing app.blade.php file has been deleted.");

                // Proceed to copy the new file.
                $this->copyFile(__DIR__ . "/../../../stubs/app.blade.php", $appBladePath);
                $this->info("The app.blade.php file has been successfully overwritten.");
            }

            if ($choice === 'Skip') {
                $this->info("Skipping app.blade.php installation.");
                return; // Skip the rest of the installation if the user chooses to skip.
            }

            if ($choice === 'Rename') {
                // Prompt the user for a new name for the file.
                $newFileName = strtolower($this->ask("Please provide a new name for the app.blade.php file (without extension):"));
                $newFilePath = "{$layoutsPath}{$this->ds}{$newFileName}.blade.php";

                // Rename the existing file.
                $this->filesystem->move($appBladePath, $newFilePath);
                $this->info("The app.blade.php file has been renamed to: {$newFileName}.blade.php");

                // Copy the renamed component class with the first letter capitalized.
                $this->copyComponent(ucfirst($newFileName));

                // Edit the new component class file.
                $componentClassPath = app_path("View/Components/" . ucfirst($newFileName) . "Layout.php");
                $this->updateComponentClass($componentClassPath, ucfirst($newFileName));

                // Edit the new Blade file to include the renamed component.
                $contents = File::get($newFilePath);

                // Replace the component name in the file.
                $contents = str($contents)->replace('AppLayout', ucfirst($newFileName) . 'Layout');

                // Update the file with the new component name.
                File::put($newFilePath, $contents);

                // Skip copying the new file since it's already renamed.
                return;
            }
        } else {
            // Copy the default app layout stub file to the layouts directory.
            $this->copyFile(__DIR__ . "/../../../stubs/app.blade.php", $appBladePath);

            $this->copyComponent();
        }
    }

    protected function copyComponent(string $newFileName = 'App'): void
    {
        // Define the path to the components directory within the project's http directory.
        $componentsPath = "app{$this->ds}View{$this->ds}Components";

        // Ensure that the components directory exists, create if not.
        $this->createDirectory($componentsPath);

        // Copy the component class with the first letter of the filename capitalized.
        $this->copyFile(__DIR__ . "/../../../stubs/AppLayout.php", "{$componentsPath}{$this->ds}{$newFileName}Layout.php");
    }

    /**
     * Update the component class file by renaming the class and its contents.
     *
     * @param string $filePath
     * @param string $newClassName
     * @return void
     */
    private function updateComponentClass(string $filePath, string $newClassName): void
    {
        if (File::exists($filePath)) {
            $classContents = File::get($filePath);

            // Replace the class name and the return view statement.
            $updatedContents = str($classContents)
                ->replace('class AppLayout', "class {$newClassName}Layout")
                ->replace("return view('layouts.app');", "return view('layouts.{$newClassName}');");

            // Save the updated contents back to the file.
            File::put($filePath, $updatedContents);

            $this->info("Component class file {$newClassName}Layout.php has been updated.");
        } else {
            $this->error("Component class file not found at {$filePath}.");
        }
    }

    /**
     * Copy a file from the source to the destination.
     *
     * @param string $source - The source file path.
     * @param string $destination - The destination file path.
     *
     * @return void
     *
     * @throws RuntimeException If the file copy fails.
     **/
    private function copyFile(string $source, string $destination): void
    {
        try {
            // Use Laravel's File facade to copy the file.
            File::copy($source, $destination);
        } catch (\Exception $e) {
            // If an exception occurs during the file copy, throw a RuntimeException.
            throw new RuntimeException("Failed to copy {$source} to {$destination}");
        }
    }


    /**
     * Create a directory if it does not already exist.
     *
     * @param string $path The path of the directory to be created.
     * 
     * @return void
     **/
    private function createDirectory(string $path): void
    {
        // Check if the directory already exists
        if (!file_exists($path)) {
            // Create the directory with read, write, and execute permissions for everyone
            mkdir($path, 0777, true);
        }
    }

    /**
     * Run a process and display its output.
     *
     * @param Process $process - The Symfony Process instance to be executed.
     * 
     * @return void
     **/
    private function runProcessWithOutput(Process $process)
    {
        // Run the process asynchronously and capture the output.
        $process->run(function (string $type, string $output) {
            // Echo the output as it is received.
            // echo $output;
        });
    }
}
