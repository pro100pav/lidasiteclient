<?php

namespace App\BotsControl;

use App\Models\User;
use App\Models\Bot\Notice;
use App\Models\Bot\UserBot;
use App\Models\UserBalance;
use App\Models\Profile;
use App\Models\ClassicPartner;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use App\Customs\Bot\BotCustomMethod;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserSave{

    public static function isadmin($result,$bot){
        if (isset($result["message"])){
            $chat_id = $result["message"]["chat"]["id"];
        }
        $username = null;
        if(isset($result["message"]["from"]["username"])){
            $username = $result["message"]["from"]["username"];
        }
        $name = 'Таинственный незнакомец';
        if(isset($result["message"]["from"]["first_name"])){
            $name = $result["message"]["from"]["first_name"];
        }
        if(isset($result["message"]["from"]["last_name"])){
            $name .= " ".$result["message"]["from"]["last_name"];
        }
        $user = User::find(1);
        if($user->id_telegram == 0){
            $user->id_telegram = $chat_id;
            $user->name = $name;
            if($username == null){
                $username = 1;
            }
            $user->username = $username;
            $user->save();
        }
    }
    public static function index($result,$bot, $template){

        $chat_id = '';
        if (isset($result["message"])){
            $chat_id = $result["message"]["chat"]["id"];
            $message_id = $result["message"]["message_id"];
        }
        if (isset($result["callback_query"])){
            $chat_id = $result["callback_query"]["from"]["id"];
            $message_id = $result["callback_query"]["message"]["message_id"];
        }
        $user = User::where('id_telegram', $chat_id)->first();
        
        $refer = null;

        if($user){
            if($user->blocked == 1){
                return 'block';
            }
        }
        if(!$user){
            $nastavnik = 1;
            if(!isset($result["message"]["text"])){
                return 'spam';
            }
            if(mb_strlen($result["message"]["text"]) > 20){
                return 'spam';
            }
            if(strstr($result["message"]["text"], '/start') && strlen($result["message"]["text"]) > 6){
                if(strlen($result["message"]["text"]) > 20){
                    return 'spam';
                }
                $nastavnik = substr($result["message"]["text"], 7);
                if(!User::find($nastavnik)){
                    $nastavnik = 1;
                }
            }
            $username = null;
            $is_username = 1;
            if(isset($result["message"]["from"]["username"])){
                $username = $result["message"]["from"]["username"];
                $is_username = 0;
            }
            $name = 'Таинственный незнакомец';
            if(isset($result["message"]["from"]["first_name"])){
                $name = $result["message"]["from"]["first_name"];
            }
            if(isset($result["message"]["from"]["last_name"])){
                $name .= " ".$result["message"]["from"]["last_name"];
            }
            
            $user = User::create([
                'id_telegram' => $chat_id,
                'name' => $name,
                'username' => $username,
                'code_auth' => rand(1000, 9999),
            ]);
            $usernameinfo = '@'.$username;
            if(!$username){
                $user->username = $user->id;
                $user->save();
            }
            
            if($user->id == 1){
                $partner = new ClassicPartner();
                $partner->bot_id = $bot->id;
                $partner->refer_id = null;
                $user->partner()->save($partner);
            }else{
                $partner = new ClassicPartner();
                $partner->bot_id = $bot->id;
                $partner->refer_id = $nastavnik;
                $user->partner()->save($partner);

                $refer = User::find($nastavnik);

                Notice::create([
                    'bot_id' => $bot->id,
                    'user_id' => $nastavnik,
                    'text' => 'По вашей реф ссылке зарегистрировался новый пользователь. @'.$username,
                    'send' => 0,
                ]);
            }

            $bt = new UserBot();
            $bt->bot_id = $bot->id;
            $user->bots()->save($bt);
    
            $balance = new UserBalance();
            $user->balance()->save($balance);
    
            $profile = new Profile();
            $user->profile()->save($profile);
            
            
        }elseif(isset($result["message"])){
            if (isset($result["message"]["text"])){
                if(strstr($result["message"]["text"], '/start') && strlen($result["message"]["text"]) > 6){
                    if(strlen($result["message"]["text"]) > 20){
                        return 'spam';
                    }
                    $nastavnik = substr($result["message"]["text"], 7);
                    $usNast = UserBot::where([['user_id', $nastavnik],['bot_id', $bot->id]])->first();
                    if($usNast){
                        $partnerka = ClassicPartner::where([['bot_id', $bot->id],['user_id',$user->id]])->first();
                        if(!$partnerka){
                            $partner = new ClassicPartner();
                            $partner->bot_id = $bot->id;
                            $partner->refer_id = $nastavnik;
                            $user->partner()->save($partner);
                            
                            $bt = new UserBot();
                            $bt->bot_id = $bot->id;
                            $user->bots()->save($bt);

                            $refer = User::find($nastavnik);

                            Notice::create([
                                'bot_id' => $bot->id,
                                'user_id' => $nastavnik,
                                'text' => 'По вашей реф ссылке зарегистрировался новый пользователь. @'.$user->username.' id '.$user->id,
                                'send' => 0,
                                
                            ]);
                        }
                    }else{
                        if($user->id == 1){
                            $partner = new ClassicPartner();
                            $partner->bot_id = $bot->id;
                            $partner->refer_id = null;
                            $user->partner()->save($partner);

                            $bt = new UserBot();
                            $bt->bot_id = $bot->id;
                            $user->bots()->save($bt);
                        }else{
                            $partner = new ClassicPartner();
                            $partner->bot_id = $bot->id;
                            $partner->refer_id = 1;
                            $user->partner()->save($partner);

                            $bt = new UserBot();
                            $bt->bot_id = $bot->id;
                            $user->bots()->save($bt);

                            $refer = User::find($nastavnik);
                            
                            Notice::create([
                                'bot_id' => $bot->id,
                                'user_id' => $nastavnik,
                                'text' => 'По вашей реф ссылке зарегистрировался новый пользователь. @'.$user->username.' id '.$user->id,
                                'send' => 0,
                                
                            ]);
                        }

                    }
                }
            }
        }

        if($refer){
            if($template->ref_dostigenie > 0){
                if(ClassicPartner::where([['bot_id',$bot->id],['refer_id', $refer->id]])->count() == $template->ref_dostigenie){
                    
                    
                    if($template->video){
                        $method = 'sendVideo';
                        $params = [
                            'chat_id' => $refer->id_telegram,
                            'video' => \Telegram\Bot\FileUpload\InputFile::create($template->video_note),

                        ];
                        $res = BotCustomMethod::index($method, $param, $bot->token);
                    }

                    if($template->images){
                        if(mb_strlen($editmessage) > 1000){
                            $method = 'sendPhoto';
                            $params = [
                                'chat_id' => $refer->id_telegram,
                                'photo' => \Telegram\Bot\FileUpload\InputFile::create($template->images),
                                'caption' => $template->ref_message,
                                'parse_mode' => 'HTML'
                            ];
                            $res = BotCustomMethod::index($method, $params, $bot->token);
                        }else{
                            $method = 'sendPhoto';
                            $params = [
                                'chat_id' => $refer->id_telegram,
                                'photo' => \Telegram\Bot\FileUpload\InputFile::create($template->images),
                                'parse_mode' => 'HTML'
                            ];
                            $res = BotCustomMethod::index($method, $params, $bot->token);
                            $method = 'sendMessage';
                            $params = [
                                'chat_id' => $refer->id_telegram,
                                'text' => $template->ref_message,
                                'parse_mode' => 'HTML'
                            ];
                            $res = BotCustomMethod::index($method, $params, $bot->token);
                        }
                    }else{
                        if($template->ref_message){
                            $method = 'sendMessage';
                            $params = [
                                'chat_id' => $refer->id_telegram,
                                'text' => $template->ref_message,
                                'parse_mode' => 'HTML'
                            ];
                            $res = BotCustomMethod::index($method, $params, $bot->token);
                        }
                    }

                    if($template->video_notice){
                        $method = 'sendVideoNote';
                        $params = [
                            'chat_id' => $refer->id_telegram,
                            'video_note' => \Telegram\Bot\FileUpload\InputFile::create($template->video_note),

                        ];
                        $res = BotCustomMethod::index($method, $params, $bot->token);
                    }
                    
                }
            }
        }
        return $user;
    }

    public static function structura($req, $page, $bot){
        if(strstr($page, 'page')){
            $pattern = substr($page, strpos($page, '?'));
            $page = preg_replace("/[^0-9]/", '', $pattern);
            
        }else{
            $page = null;
        }

        $user = User::where('id_telegram', $req)->first();
        $mass = 'У Вас 0 рефералов:'."\n";
        if($user){
            $countref = ClassicPartner::where([['bot_id',$bot->id],['refer_id', $user->id]])->count();
            $str = ClassicPartner::where([['bot_id',$bot->id],['refer_id', $user->id]])->simplePaginate(10, ['*'], 'page', $page);
            if($user->partner->where('bot_id', $bot->id)->first()->nastavnik){
                $nast = $user->partner->where('bot_id', $bot->id)->first()->nastavnik->username;
                if (is_numeric($user->partner->where('bot_id', $bot->id)->first()->nastavnik->username)) {
                    $nast = 'У пользователя нет Username';
                }
                $mass = "Тебя пригласил пользователь @$nast \nУ Вас $countref рефералов:\n";
            }else{
                $mass = "У вас $countref рефералов:\n";
            }
            $i = 0;
            foreach($str as $item){
                if (!is_numeric($item->user->username)) {
                    $mass .= '@'.$item->user->username." id ".$item->user->id."\n";
                    $i++;
                }else{
                    $mass .= "Нет Username у пользователя. id ".$item->user->id."\n";
                    $i++;
                }
            }
            $buttons = [];
            if($str->currentPage() > 1){
                $buttons[] = [
                    'text' => '<<',
                    'callback_data' => '/kandidat?page='.$str->currentPage()-1,
                ];
                if($str->hasMorePages()){
                    $buttons[] = [
                        'text' => '>>',
                        'callback_data' => '/kandidat?page='.$str->currentPage()+1,
                    ];
                }
            }else{
                if($str->hasMorePages()){
                    $buttons[] = [
                        'text' => '>>',
                        'callback_data' => '/kandidat?page='.$str->currentPage()+1,
                    ];
                }
            }
            $reply_markup = Keyboard::make([
                'inline_keyboard' => [
                    $buttons,
                    [
                        [
                            'text' => 'Вернуться в меню',
                            'callback_data' => '/menu',
                        ]
                    ]
                ],
                'resize_keyboard' => true,
            ]);
            if($countref > 10 && $page != null){
                if($user->bots->where('bot_id', $bot->id)->first()->last_message != null){
                    Log::info(json_encode($page, JSON_UNESCAPED_UNICODE));
                    return [
                        'method' => 'editMessageText',
                        'params' => [
                            'chat_id' => $req,
                            'message_id' => $user->bots->where('bot_id', $bot->id)->first()->last_message,
                            'text' => $mass,
                            'reply_markup' => $reply_markup,
                        ]
                    ];
                }else{
                    return [
                        'method' => 'sendMessage',
                        'params' => [
                            'chat_id' => $req,
                            'text' => $mass,
                            'reply_markup' => $reply_markup,
                        ]
                    ];
                }
                
            }else{
                return [
                    'method' => 'sendMessage',
                    'params' => [
                        'chat_id' => $req,
                        'text' => $mass,
                        'reply_markup' => $reply_markup,
                    ]
                ];
            }
            
        }
        return [
            'method' => 'sendMessage',
            'params' => [
                'chat_id' => $req,
                'text' => 'Вернитесь в начало /start',
            ]
        ];
    }

    public static function kiked($bot,$chat_id){
        $distrib = Distribution::where([['bot_id', $bot->id],['id_telegram', $chat_id]])->first();
        if($distrib){
            $distrib->status = 1;
            $distrib->save();
        }
    }
}