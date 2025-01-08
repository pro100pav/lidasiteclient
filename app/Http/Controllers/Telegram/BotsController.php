<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Auth;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\UserBot;
use App\Models\Bot\BotTemplate;
use App\Models\Bot\BotMessage;
use App\Models\Bot\BotItemMessage;
use App\Models\Bot\BotButton;
use App\Models\Bot\ChatUser;
use App\Models\Bot\ChatUserMessage;
use App\Models\Bot\SocialGroup;
use App\Models\Bot\SocialGroupUser;
use App\Models\Bot\Notice;
use App\Customs\Bot\BotCustomMethod;
use App\BotsControl\UserSave;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
class BotsController extends Controller
{

    public function index(Request $request, $id){
        $bot = Bot::find($id);
        $token = $bot->token;
        $telegram = new Api($token);
        $result = $telegram->getWebhookUpdates();
        //Log::info(json_encode($result, JSON_UNESCAPED_UNICODE));
        if($bot){
            $temp = BotTemplate::where([['bot_id', $bot->id],['active', 1]])->first();
            if($temp){
                if (isset($result["message"])){
                    if(($result['message']["chat"]['type'] == 'private')){
                        $chat_id = $result["message"]["chat"]["id"];
                        $message = '';
                        if(isset($result["message"]['text'])){
                            $message = $result["message"]['text'];
                        }

                        $userad = UserSave::isadmin($result, $bot);
                        $user = UserSave::index($result, $bot,$temp);
                        
                        if($user == 'spam'){
                            try {
                                $response = $telegram->sendMessage([
                                    'chat_id' => $chat_id,
                                    'text' => 'Не надо спамить',
                                ]);
                                Log::emergency('Спамят');
                            } catch (TelegramResponseException $e) {
                                $response = "Заблокирован";
                            }
                        }elseif($user == 'non refer'){
                            try {
                                $response = $telegram->sendMessage([
                                    'chat_id' => $chat_id,
                                    'text' => 'Доступ к чат боту только по ссылке приглашению',
                                    
                                ]);
                                
                                Log::emergency('без рефссылки');
                            } catch (TelegramResponseException $e) {
                                $response = "Заблокирован";
                            }
                        }elseif($user == 'block'){
                            return;
                        }else{
                            if(!strstr($message, '/proverkaPodpis') || !strstr($message, '/referals')){
                                if(mb_strlen($message) < 20){
                                    $user->bots->where('bot_id', $bot->id)->first()->last_message = $message;
                                    $user->bots->where('bot_id', $bot->id)->first()->save();
                                }
                            }
                            if($temp->privat == 1){
                                $groups = $temp->groups;
                                if($groups->count() > 0){
                                    $resPrivat = $this->privatMessage($telegram, $user, $chat_id, $groups);
                                    if($resPrivat == 0){
                                        $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot, true);
                                    }else{
                                        $reply_markup = Keyboard::make([
                                            'inline_keyboard' => [
                                                [
                                                    [
                                                        'text' => 'Проверить',
                                                        'callback_data' => $user->bots->where('bot_id', $bot->id)->first()->last_message,
                                                    ]
                                                ],
                                            ],
                                            'resize_keyboard' => true,
                                        ]);
                                        try {
                                            $response = $telegram->sendMessage([
                                                'chat_id' => $chat_id,
                                                'text' => $temp->message,
                                                'reply_markup' => $reply_markup,
                                                'parse_mode' => 'MarkDown',
                                            ]);
                                        } catch (TelegramResponseException $e) {
                                            Log::emergency($e);
                                            $response = "Заблокирован";
                                        }
                                    }
                                }else{
                                    $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot, true);
                                }
                                
                            }else{
                                $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot, true);
                            }
                            
                        }
                        
                    }
                    if(in_array($result['message']["chat"]['type'], ['supergroup','group','channel'])){
                        if(isset($result["message"]['new_chat_participant'])){
                            try {
                                $res = $telegram->deleteMessage([
                                    'chat_id' => $result['message']["chat"]['id'],
                                    'message_id' => $result["message"]['message_id'],
                                ]);
                            } catch (TelegramResponseException $e) {
                                return false;
                            }
                        }else{
                            //Log::info(json_encode($result, JSON_UNESCAPED_UNICODE));
                        }
                        
                    }
                }
                if(isset($result['callback_query'])){
                    if(($result["callback_query"]['message']["chat"]['type'] == 'private')){
                        $chat_id = $result["callback_query"]['message']["chat"]["id"];
                        if(in_array($chat_id, ['5997768991'])){
                            return;
                        }
                        $message = $result["callback_query"]['data'];
                        $user = UserSave::index($result, $bot,$temp);
                        if(!strstr($message, '/proverkaPodpis') || !strstr($message, '/referals')){
                            if(mb_strlen($message) < 20){
                                $user->bots->where('bot_id', $bot->id)->first()->last_message = $message;
                                $user->bots->where('bot_id', $bot->id)->first()->save();
                            }
                            
                        }
                        if($temp->privat == 1){
                            $groups = $temp->groups;
                            if($groups->count() > 0){
                                $resPrivat = $this->privatMessage($telegram, $user, $chat_id, $groups);
                                if($resPrivat == 0){
                                    $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot);
                                }else{
                                    $reply_markup = Keyboard::make([
                                        'inline_keyboard' => [
                                            [
                                                [
                                                    'text' => 'Проверить',
                                                    'callback_data' => $user->bots->where('bot_id', $bot->id)->first()->last_message,
                                                ]
                                            ],
                                        ],
                                        'resize_keyboard' => true,
                                    ]);
                                    try {
                                        $response = $telegram->sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $temp->message,
                                            'reply_markup' => $reply_markup,
                                            'parse_mode' => 'MarkDown',
                                        ]);
                                    } catch (TelegramResponseException $e) {
                                        Log::emergency($e);
                                        $response = "Заблокирован";
                                    }
                                }
                            }else{
                                $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot);
                            }
                            
                        }else{
                            $this->chatMenegment($telegram, $user, $result, $chat_id, $message, $temp, $bot);
                        }
                        
                    }
                }
                
            }
            if (isset($result["message"])){
                
                if (isset($result["my_chat_member"])){
                    if(in_array($result['my_chat_member']["chat"]['type'], ['supergroup','group','channel'])){
                        if($result["my_chat_member"]['new_chat_member']['user']['is_bot'] == true){
                            
                            $this->menegerGroup($telegram,$result,$bot);
                        }
                    }
                    if(($result['my_chat_member']["chat"]['type'] == 'private')){
                        if(isset($result["message"])){
                            //$this->chatMenegment($this->result);
                        }else{
                            return;
                        }
                    }
                }
            }
            if (isset($result["my_chat_member"])){
                if(in_array($result['my_chat_member']["chat"]['type'], ['supergroup','group','channel'])){
                    if($result["my_chat_member"]['new_chat_member']['user']['is_bot'] == true){
                        
                        $this->menegerGroup($telegram,$result,$bot);
                    }
                }
                if(($result['my_chat_member']["chat"]['type'] == 'private')){
                    if(isset($result["message"])){
                        //$this->chatMenegment($this->result);
                    }else{
                        return;
                    }
                }
            }
        }
    }

    function menegerGroup($telegram,$req,$bot){
        $id = $req['my_chat_member']['chat']['id'];
        $type = $req["my_chat_member"]['chat']['type'];
        $name = $req['my_chat_member']['chat']['title'];
        $username = 'Отсутсвует';
        if(isset($req['my_chat_member']['chat']['username'])){
            $username = $req['my_chat_member']['chat']['username'];
        }

        $botisgroup = SocialGroup::where([['id_group', $id],['bot_id', $bot->id]])->first();
        if(!$botisgroup){
            if($req['my_chat_member']['new_chat_member']['status'] == 'administrator'){
                $newtype = 1;
                if($type == 'channel'){
                    $newtype = 1;
                }
                if($type == 'group'){
                    $newtype = 2;
                }
                $group = SocialGroup::create([
                    'bot_id'=> $bot->id,
                    'id_group'=> $id,
                    'group_name'=> $name,
                    'username'=> $username,
                    'type'=> $newtype,
                    'status'=> 1,
                ]);
            }
        }else{
            if($req['my_chat_member']['new_chat_member']['status'] == 'left'){
                $botisgroup->status = 3;
                $botisgroup->save();
            }
            if($req['my_chat_member']['new_chat_member']['status'] == 'administrator'){
                $botisgroup->status = 1;
                $botisgroup->save();
            }else{
                $botisgroup->status = 3;
                $botisgroup->save();
            }
        }
    }

    function chatMenegment($telegram, $user, $res, $chat_id, $message, $temp, $bot, $trigger = null){
        $usBot = $user->bots->where('bot_id', $bot->id)->first();
        if($usBot->chat){
            $mc = new ChatUserMessage();
            $mc->message_user = $message;
            $usBot->chat->messages()->save($mc);
        }else{
            $chat = ChatUser::create([
                'user_bot_id'=>$user->id,
            ]);
            $mc = new ChatUserMessage();
            $mc->message_user = $message;
            $chat->messages()->save($mc);
        }
        if($user->isstepBot($bot->id) > 1){
            return;
        }else{
            if(strstr($message, '/start')){
                $message = '/start';
            }

            $bdMes = $temp->messages;
            $mes = null;
            foreach($bdMes as $messa){
                $number = $message;
                if(strstr($message, '?')){
                    $str = $message;
                    $symbol = "?";
                    $position = strpos($str, $symbol);
                    $number = substr($str, 0, $position);
                }
                if(!$trigger){
                    if (is_numeric($number)) {
                        if($messa->id_message == $number){
                            $mes = $messa;
                        }
                    }else{
                        if($messa->trigger == $number){
                            $mes = $messa;
                        }
                    }
                    
                }else{
                    if($messa->trigger == $number){
                        $mes = $messa;
                    }
                }
            }
            if($mes){
                $resPrivat = 0;
                if($mes->privat == 1){
                    $groups = $mes->groups;
                    if($groups->count() > 0){
                        $resPrivat = $this->privatMessage($telegram, $user, $chat_id, $groups);
                    }
                }
                if($resPrivat == 0){
                    foreach($mes->items as $item){
                        if($item->function == 'referals'){
                            
                            $data = UserSave::structura($chat_id, $message, $bot);
                            $method = $data['method'];
                            $params = $data['params'];
                            try {
                                $response = $telegram->$method($params);
                                if(isset($response['message_id'])){
                                    $user->bots->where('bot_id', $bot->id)->first()->last_message = $response["message_id"];
                                    $user->bots->where('bot_id', $bot->id)->first()->save();
                                }
                            } catch (TelegramResponseException $e) {
                                $response = "Заблокирован";
                            }
                        }else{
                            $editmessage = '';
                            if($item->message){
                                $editmessage = $this->editText($user, $res, $item->message, $bot);
                                $mc = new ChatUserMessage();
                                $mc->message_bot = $editmessage;
                                $usBot->chat->messages()->save($mc);
                            }
                            $buttons = [];
                            $button = [];
                            $reply_markup = Keyboard::make([
                                'keyboard' => [[]],
                                'resize_keyboard' => true
                            ]);
                            if($item->buttons->count() > 0){
                                $i = 1;
                                foreach($item->buttons as $itembutton){
                                    if($itembutton->type_button == 1){
                                        $button[] = ['text' => $itembutton->text, 'callback_data' => $itembutton->callback_button];
                                    }elseif($itembutton->type_button == 3){
                                        if(is_numeric($itembutton->callback_button)){
                                            $preobraz = ['text' => $itembutton->text, 'url' => $bot->link.'?start='.$user->id];
                                            $refbot = Bot::find($itembutton->callback_button);
                                            if($refbot){
                                                if($user->partner->where('bot_id', $bot->id)->first()->nastavnik){
                                                    $botUs = UserBot::where([['bot_id', $itembutton->callback_button],['user_id', $user->partner->where('bot_id', $bot->id)->first()->nastavnik->id]])->first();
                                                    if($botUs){
                                                        $preobraz = ['text' => $itembutton->text, 'url' => $refbot->link.'?start='.$botUs->user_id];
                                                    }else{
                                                        foreach($user->breadcrumbspartner($bot->id) as $partner){
                                                            if(UserBot::where([['bot_id', $itembutton->callback_button],['user_id', $partner->user_id]])->first()){
                                                                $preobraz = ['text' => $itembutton->text, 'url' => $refbot->link.'?start='.$partner->user_id];
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    $preobraz = ['text' => $itembutton->text, 'url' => $refbot->link.'?start='.$user->id];
                                                }
                                                
                                            }
                                            
                                        }
                                        $button[] = $preobraz;
                                    }else{
                                        if($itembutton->callback_button == 'ref'){
                                            $button[] = ['text' => $itembutton->text, 'url' => $bot->link.'?start='.$user->id];
                                        }else{
                                            $button[] = ['text' => $itembutton->text, 'url' => $itembutton->callback_button];
                                        }
                                        
                                    }
                                    if($i % 2 == 0) {
                                        $buttons[] = $button;
                                        $button = [];
                                    }
                                    $i++;
                                }
                                $buttons[] = $button;
                                $reply_markup = Keyboard::make([
                                    'inline_keyboard' => $buttons,
                                    'resize_keyboard' => true
                                ]);
                            }
                            $mesend = 0;
                            $protect = false;
                            if($item->privat == 1){
                                $protect = true;
                            }
                            if($item->images){
                                if(mb_strlen($editmessage) > 1000){
                                    try {
                                        $response = $telegram->sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $editmessage,
                                            'protect_content' => $protect,
                                            'reply_markup' => $reply_markup,
                                        ]);
                                        $mesend = 1;
                                    } catch (TelegramResponseException $e) {
                                        Log::emergency($e);
                                        return;
                                    }
                                }else{
                                    try {
                                        $response = $telegram->sendPhoto([
                                            'chat_id' => $chat_id,
                                            'photo' => \Telegram\Bot\FileUpload\InputFile::create($item->images),
                                            'caption' => $editmessage,
                                            'protect_content' => $protect,
                                            'reply_markup' => $reply_markup,
                                            'parse_mode' => 'MarkDown',
                                        ]);
                                        $mesend = 1;
                                    } catch (TelegramResponseException $e) {
                                        $response = "Заблокирован";
                                    }
                                }
                            }

                            if($item->video){
                                if($mesend == 1){
                                    try {
                                        $response = $telegram->sendVideo([
                                            'chat_id' => $chat_id,
                                            'video' => \Telegram\Bot\FileUpload\InputFile::create($item->video),
                                            'supports_streaming'=> true,
                                            'protect_content' => $protect,
                                            'reply_markup' => $reply_markup,
                                            'parse_mode' => 'MarkDown',
                                        ]);
                                    } catch (TelegramResponseException $e) {
                                        $response = "Заблокирован";
                                    }
                                }else{
                                    try {
                                        $response = $telegram->sendVideo([
                                            'chat_id' => $chat_id,
                                            'video' => \Telegram\Bot\FileUpload\InputFile::create($item->video),
                                            'caption' => $editmessage,
                                            'supports_streaming'=> true,
                                            'protect_content' => $protect,
                                            'reply_markup' => $reply_markup,
                                            'parse_mode' => 'MarkDown',
                                        ]);
                                        $mesend = 1;
                                    } catch (TelegramResponseException $e) {
                                        $response = "Заблокирован";
                                    }
                                }
                                
                            }
                            if($item->video_notice){
                                try {
                                    $response = $telegram->sendVideoNote([
                                        'chat_id' => $chat_id,
                                        'video_note' => \Telegram\Bot\FileUpload\InputFile::create($item->video_notice),
                                        'protect_content' => $protect,
                                    ]);
                                } catch (TelegramResponseException $e) {
                                    $response = "Заблокирован";
                                }
                            }
                            if($item->message){
                                if($mesend == 0){
                                    try {
                                        $response = $telegram->sendMessage([
                                            'chat_id' => $chat_id,
                                            'text' => $editmessage,
                                            'protect_content' => $protect,
                                            'reply_markup' => $reply_markup,
                                        ]);
                                    } catch (TelegramResponseException $e) {
                                        Log::emergency($e);
                                        return;
                                    }
                                }
                                
                            }else{
                                return;
                            }

                            
                        }
                    }
                }else{
                    $reply_markup = Keyboard::make([
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => 'Проверить',
                                    'callback_data' => $user->bots->where('bot_id', $bot->id)->first()->last_message,
                                ]
                            ],
                        ],
                        'resize_keyboard' => true,
                    ]);
                    try {
                        $response = $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => $mes->message,
                            'reply_markup' => $reply_markup,
                            'parse_mode' => 'MarkDown',
                        ]);
                    } catch (TelegramResponseException $e) {
                        Log::emergency($e);
                        $response = "Заблокирован";
                    }
                }
                
            }else{
                return;
            }
        }
        
    }
    function editText($user, $res, $text, $bot){
        if (false !== mb_strpos($text, '%name%')) {
            $text = str_replace('%name%', $user->name, $text);
        }
        if (false !== mb_strpos($text, '%id%')) {
            $text = str_replace('%id%', $user->id, $text);
            
        }

        if (false !== mb_strpos($text, '%userreflink%')) {
            if($user){
                $text = str_replace('%userreflink%', $bot->link.'?start='.$user->id, $text);
            }else{
                $text = str_replace('%userreflink%', 'Ваша реф ссылка еще не готова', $text);
            }
        }

        if(false !== mb_strpos($text, '%alluser%')){
            $text = str_replace('%alluser%', UserBot::where('bot_id', $bot->id)->count(), $text);
        }
        if(false !== mb_strpos($text, '%referuser%')){
            $partner = '';
            
            if ($user->partner->where('bot_id', $bot->id)->first()->nastavnik){
                if (is_numeric($user->partner->where('bot_id', $bot->id)->first()->nastavnik->username)) {
                    $partner = "У пользователя нет username";
                } else {
                    $partner = "@".$user->partner->where('bot_id', $bot->id)->first()->nastavnik->username;
                }
            }else{
                $partner = 'Ты первый';
            }
            
            
            $text = str_replace('%referuser%', $partner, $text);
        }
        if(false !== mb_strpos($text, '%countine%')){
            
            $text = str_replace('%countine%', $user->partner->where('bot_id', $bot->id)->first()->partner->count(), $text);
        }
        
        return $text;
    }
    function privatMessage($telegram, $user, $chat_id, $groups){
        $no = 0;
        if($groups){
            foreach($groups as $group){
                $res = $telegram->getChatMember([
                    "chat_id" => $group->id_group,
                    "user_id" => $chat_id,
                ]);
                if(!in_array($res['status'], ['member','creator','administrator'])){
                    $no += 1;
                }
            }
        }
        return $no;
    }

    function url_get_contents ($Url) {
        if (!function_exists('curl_init')){
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
