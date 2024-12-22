<?php

namespace App\Customs\Bot;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use App\Models\Bot\GroupTelegram;
use App\Models\Bot\GroupMember;
use Illuminate\Support\Facades\Log;

class UserUpdateChat{

    public static function kiked($user){

        $token = '6551824350:AAH5ljk-F8ScV-ZIuYPvW3H2dZSPyCss-g0';
        $telegram = new Api($token); //Устанавливаем токен, полученный у BotFather
        $result = $telegram->getWebhookUpdates();
        if($user->id_telegram != 0){
            $res = $telegram->getChatMember([
                "chat_id" => "-1001865773705",
                "user_id" => $user->id_telegram,
            ]);
            if(in_array($res['status'], ['member'])){
                try {
                    $res = $telegram->kickChatMember([
                        "chat_id" => "-1001865773705",
                        "user_id" => $user->id_telegram,
                    ]);
                } catch (TelegramResponseException $e) {
                    Log::emergency($e);
                }
            }
        }
        
    }
    public static function unkiked($user){
        $token = '6551824350:AAH5ljk-F8ScV-ZIuYPvW3H2dZSPyCss-g0';
        $telegram = new Api($token); //Устанавливаем токен, полученный у BotFather
        $result = $telegram->getWebhookUpdates();
        if($user->id_telegram != 0){
            $res = $telegram->getChatMember([
                "chat_id" => "-1001865773705",
                "user_id" => $user->id_telegram,
            ]);
    
            if(in_array($res['status'], ['kicked'])){
                try {
                    $res = $telegram->unbanChatMember([
                        "chat_id" => "-1001865773705",
                        "user_id" => $user->id_telegram,
                    ]);
                } catch (TelegramResponseException $e) {
                    Log::emergency($e);
                }
            }
        }
        
        
    }
}