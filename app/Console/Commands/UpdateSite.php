<?php
namespace App\Console\Commands;

use App\Models\UpdateSistem;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class UpdateSite extends Command
{
    protected $signature = 'git:pull';
    protected $description = 'Pull files from GIT';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){

        $commands = [
            'git pull origin master',
        ];

        // foreach ($commands as $command) {
        //     echo "Выполняю: $command\n";
        //     $output = [];
        //     $return_var = 0;
        //     exec($command, $output, $return_var);
        
        //     if ($return_var === 0) {
        //         echo "Успех\n";
        //     } else {
        //         echo "Ошибка (код $return_var):\n" . implode("\n", $output) . "\n";
        //     }
        //     Log::info(json_encode('upd', JSON_UNESCAPED_UNICODE));
        // }
        // Artisan::call('migrate');
        $updateS = UpdateSistem::where('new_update', 2)->first();
        if($updateS){
            $commands = [
                'git pull origin master',
            ];
    
            foreach ($commands as $command) {
                echo "Выполняю: $command\n";
                $output = [];
                $return_var = 0;
                exec($command, $output, $return_var);
            
                if ($return_var === 0) {
                    echo "Успех\n";
                } else {
                    echo "Ошибка (код $return_var):\n" . implode("\n", $output) . "\n";
                }
                Log::info(json_encode('upd', JSON_UNESCAPED_UNICODE));
            }
            Artisan::call('migrate');
            $updateS->new_update = 3;
            $updateS->save();
            
        }
        return;
    }

}