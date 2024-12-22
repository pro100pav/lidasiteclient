<?php

namespace App\Console\Commands;

use App\Models\Bot\UserBot;
use App\Models\Bot\Bot;
use App\Models\Bot\Notice;
use Illuminate\Console\Command;
use App\Customs\Bot\BotCustomMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class SendNotiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendNoti:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle(): void
    {
        $notify = Notice::where('send',0)->get();
        $i = 1;
        
        foreach($notify as $send){
            $user = $send->user;
            $bot = Bot::find(1);
            if($send->bot_id != null){
                $bot = Bot::find($send->bot_id);
            }
            if(UserBot::where([['user_id', $user->id],['bot_id', $bot->id]])->first()){
                $res = BotCustomMethod::index('sendMessage', [
                    'chat_id' => $user->id_telegram,
                    'text' => $send->text,
                    'parse_mode' => 'HTML',
                ], $bot->token);
                $send->send = 1;
                $send->save();
                $i++;
                if($i == 25){
                    sleep(1);
                    $i = 1;
                }
            }
            
        }

    }
}
