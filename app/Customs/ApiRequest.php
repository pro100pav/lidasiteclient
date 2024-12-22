<?php

namespace App\Customs;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ApiRequest{

    public static function send($token,$method,$params){
        $telegram = new Api($token); //Устанавливаем токен, полученный у BotFather
        $result = $telegram->getWebhookUpdates();
        try {
            $res = $telegram->$method($params);
            return $res;
        } catch (TelegramResponseException $e) {
            return false;
        }
    }
}