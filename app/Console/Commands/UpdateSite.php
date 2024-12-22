<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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

        $this->info("Succesfully updated the application.");


    }




    /**
     * Run git pull process
     * 
     * @return boolean
     */

    private function runPull()
    {

        $git_dir = base_path(); //или другой путь к вашему проекту
        $process1 = new Process(['git', 'config', '--global', '--add', 'safe.directory', $git_dir]);

        $process1->run();

        if (!$process1->isSuccessful()) {
            \Log::error('Ошибка при добавлении безопасной директории', [
                'command' => $process->getCommandLine(),
                'exit_code' => $process->getExitCode(),
                'error_output' => $process->getErrorOutput()
            ]);
        }
        else {
                \Log::info('Директория добавлена в список безопасных', [
                'command' => $process->getCommandLine()
            ]);
        }

        $process = new Process(['git', 'pull','origin','master']);
        $this->info("Running 'git pull'");
        
        $process->run();
        dd($process->getErrorOutput());
        return $process->isSuccessful();

    }



    /**
     * Run composer install process
     * 
     * @return boolean
     */

    private function runComposer()
    {

        $process = new Process('composer install');
        $this->info("Running 'composer install'");

        $process->run(function($type, $buffer) {
            $this->composerLog[] = $buffer;
        });


        return $process->isSuccessful();



    }


}