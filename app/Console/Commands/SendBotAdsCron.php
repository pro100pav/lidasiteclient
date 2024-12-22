<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Bot\UserBot;
use App\Models\Bot\AddsPost;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DateTime;

class SendBotAdsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendBotAds:cron';

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
        $post = AddsPost::where('status',3)->first();
        if(!$post){
            $post = AddsPost::where('status', 2)->first();
            if($post){
                $date = Carbon::now();
                $post->sendstart_at = $date;
                $post->status = 3;
                $post->save();
                // Получите список пользователей, которым нужно отправить сообщения
                $notify = UserBot::where([['bot_id', $post->bot_id],['sending', 0],['status', 0]]);
                $telegram = new Api($post->boting->token); //Устанавливаем токен, полученный у BotFather
                $result = $telegram->getWebhookUpdates();
                $countResult = 0;
                foreach ($notify->get() as $item) {
                    if($item->sending == 0){
                        $method = 'sendMessage';
                        $params = [
                            'chat_id' => $item->user->id_telegram,
                            'parse_mode' => 'HTML'
                        ];
                        if($post->button){
                            $reply_markup = Keyboard::make([
                                'inline_keyboard' => [
                                    [
                                        [
                                            'text' => 'Подробнее',
                                            'url' => $post->button,
                                        ]
                                    ],
                                ],
                                'resize_keyboard' => true,
                            ]);
                            $params['reply_markup'] = $reply_markup;
                        }
                        if($post->attachment){
                            $method = 'sendPhoto';
                            $params['photo'] = \Telegram\Bot\FileUpload\InputFile::create($post->attachment);
                            $params['caption'] = $post->content;
                        }else{
                            $params['text'] = $post->content;
                        }
                        try {
                            $telegram->$method($params);
                            $countResult++;
                            if($countResult % 100 == 0){
                                $chunk = $notify->take($countResult);
                                $chunk->update(["sending" => 1]);
                                $count = 0;
                            }
                        } catch (TelegramResponseException $e) {
                            $item->status = 1;
                            $item->save();
                        }
                        if ($countResult % 1000 == 0) {
                            sleep(10); // Задержка на 10 секунд
                        }
                        usleep(200000); // Задержка на 0.2 секунды
                    }
                    
                    
                }
                
                $post->status = 4;
                $post->save();

                
                $notif1 = UserBot::where([['bot_id', $post->bot_id],['sending', 1],['status', 0]]);
                $notif1->update(["sending" => 0]);
                $admin = User::find(1);
                $telegram->sendMessage([
                    'chat_id' => $admin->id_telegram,
                    'text' => "Раcсылка завершена. Отправлено сообщений $countResult",
                    'parse_mode' => 'HTML',
                ]);
            }
        }
        
    }
}
