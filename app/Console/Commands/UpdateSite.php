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

    

}