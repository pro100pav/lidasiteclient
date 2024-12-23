<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;

class UpdateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull files from GIT';

    /**
     * Is the code already updated or not
     * 
     * @var boolean
     */
    private $alreadyUpToDate;

    /**
     * Log from git pull
     * 
     * @var array
     */
    private $pullLog = [];

    /**
     * Log from composer install
     * 
     * @var boolean
     */
    private $composerLog = [];

    /**
     * Log from composer install
     * 
     * @var boolean
     */
    private $migrateLog = [];



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if(!$this->runPull()) {

            $this->error("An error occurred while executing 'git pull'. \nLogs:");
            
            foreach($this->pullLog as $logLine) {
                $this->info($logLine);
            }

            return;
        }


        if($this->alreadyUpToDate) {
            $this->info("The application is already up-to-date");
            return;
        }


        if(!$this->runComposer()) {

            $this->error("Error while updating composer files. \nLogs:");

            foreach($this->composerLog as $logLine) {
                $this->info($logLine);
            }

            return;
        }

        if(!$this->runMigrate()) {

            Artisan::call('migrate:install');

            return;
        }

        $this->info("Succesfully updated the application.");


    }




    /**
     * Run git pull process
     * 
     * @return boolean
     */

    private function runPull()
    {

        $process = new Process(['git', 'pull','origin','master']);
        $this->info("Running 'git pull'");

        $process->run(function($type, $buffer) {
            $this->pullLog[] = $buffer;

            if($buffer == "Already up to date.\n") {
                $this->alreadyUpToDate = TRUE;
            }
            
        });
        
        return $process->isSuccessful();

    }



    /**
     * Run composer install process
     * 
     * @return boolean
     */

    private function runComposer()
    {

        $process = new Process(['composer', 'install']);
        $process->setTimeout(300); //Установите таймаут для Composer, чтобы предотвратить зависание.
        $this->info("Running 'composer install'");
        try {
            $process->run();
            if (!$process->isSuccessful()) {
                $this->error("Composer install failed:");
                $this->displayCommandOutput($process); // Подробности о проблеме
                return false;
            }
            $this->info("Composer install successful.");
            return true;
        } catch (\Exception $e) {
            $this->error("Composer install failed (exception): " . $e->getMessage());
            return false;
        }


        return $process->isSuccessful();



    }
    private function runMigrate()
    {

        $process = new Process(['php', 'artisan', 'migrate']);
        $process->setTimeout(300); //Установите таймаут для миграций.
        $this->info("Running 'php artisan migrate'");
        try {
            $process->run();
            if (!$process->isSuccessful()) {
                $this->error("Migration failed:");
                $this->displayCommandOutput($process);
                return false;
            }
            $this->info("Migration successful.");
            return true;
        } catch (\Exception $e) {
            $this->error("Migration failed (exception): " . $e->getMessage());
            return false;
        }

        

    }
    protected function displayCommandOutput(Process $process) {
        foreach ($process->getOutput() as $output) {
            $this->info($output);
        }
        foreach ($process->getErrorOutput() as $errorOutput) {
            $this->error($errorOutput);
        }
    }

}