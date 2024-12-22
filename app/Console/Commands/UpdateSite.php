<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Config;

class UpdateSite extends Command
{
    protected $signature = 'git:pull';
    protected $description = 'Выполняет git pull origin master';

    public function handle()
    {
        $this->info('Начинаю git pull...');

        $process = new Process(['git', 'pull', 'origin', 'master']);
        $process->setWorkingDirectory(base_path()); //  очень важно

        try {
            $process->run();

            if (!$process->isSuccessful()) {
              $this->error("Ошибка при git pull: ". $process->getErrorOutput());
               return false;
            }
            $this->info('Git pull успешно выполнен!');
             return true;
        } catch (ProcessFailedException $exception) {
            $this->error('Git pull не удался: ' . $exception->getMessage());
             return false;
        }
    }
}