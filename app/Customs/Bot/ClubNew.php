<?php

namespace App\Customs\Bot;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\Profile;
use App\Models\Bot\UserBot;
use App\Models\Bot\Notice;
use App\Models\Bot\Distribution;
use App\Models\Partner\ClassicPartner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClubNew{

    public static function CheckUser($req){

        $chat_id = '';
        if (isset($req["message"])){
            $chat_id = $req["message"]["chat"]["id"];
        }
        if (isset($req["callback_query"])){
            $chat_id = $req["callback_query"]["from"]["id"];
        }
        $user = User::where('id_telegram', $chat_id)->first();
        if(!$user){
            $nastavnik = 3;
            if($chat_id == 555530711){
                $nastavnik = null;
            }
            if(strstr($req["message"]["text"], '/start') && strlen($req["message"]["text"]) > 6){
                if(strlen($req["message"]["text"]) > 20){
                    return 'spam';
                }
                $nastavnik = substr($req["message"]["text"], 7);
                if(!User::find($nastavnik)){
                    $nastavnik = 3;
                }
            }
            $username = null;
            $is_username = 1;
            if(isset($req["message"]["from"]["username"])){
                $username = $req["message"]["from"]["username"];
                $is_username = 0;
            }
            $name = 'Таинственный незнакомец';
            if(isset($req["message"]["from"]["first_name"])){
                $name = $req["message"]["from"]["first_name"];
            }
            if(isset($req["message"]["from"]["last_name"])){
                $name .= " ".$req["message"]["from"]["last_name"];
            }
            $password = Str::password(8, true, true, false, false);
            $user = User::create([
                'id_telegram' => $chat_id,
                'name' => $name,
                'notice' => 1,
                'username' => $username,
                'password' => Hash::make($password),
                'tokenlogin' => substr(md5($chat_id), 0, 8),
                'temporary_password' => $password,
                'is_username' => $is_username,
                'linkvisit' => $req["message"]["text"],
            ]);
            $usernameinfo = '@'.$username;
            if(!$username){
                $user->username = $user->id;
                $user->save();
                $usernameinfo = 'отсутствует ссылка на телеграм';
            }
            if($nastavnik == 1){
                $nastavnik = 3;
            }
            $partner = new ClassicPartner();
            $partner->refer_id = $nastavnik;
            $partner->token = substr(md5($user->id), 0, 8);
            $user->partner()->save($partner);
    
            $balance = new UserBalance();
            $user->balance()->save($balance);
    
            $profile = new Profile();
            $profile->avatar = 'https://storage.yandexcloud.net/turbostorage/template/ava.jpg';
            $user->profile()->save($profile);
            
            Storage::disk('yandexcloud')->makeDirectory($user->id);
            Storage::disk('yandexcloud')->makeDirectory($user->id.'/photo');
            Storage::disk('yandexcloud')->makeDirectory($user->id.'/photo/chek');
            Storage::disk('yandexcloud')->makeDirectory($user->id.'/photo/status');
            Storage::disk('yandexcloud')->makeDirectory($user->id.'/avatar');
            if($chat_id != 555530711){
                Notice::create([
                    'user_id' => $nastavnik,
                    'text' => 'По вашей реф ссылке зарегистрировался новый пользователь. '.$usernameinfo.' id '.$user->id,
                    'send' => 0,
                ]);
            }
            
            return $user;
        }
        if($user->istelegram == 2){
            $password = Str::password(8, true, true, false, false);
            $user->password = Hash::make($password);
            $user->temporary_password = $password;
            $user->istelegram = 1;
            $user->save();
        }
        return $user;
    }
    public static function structura($req){
        $user = User::where('id_telegram', $req)->first();
        $mass = 'Уровень 1 (0 рефералов):'."
";
        if($user){
            $str = ClassicPartner::where('refer_id', $user->id)->get();
            if($user->partner->nastavnik){
                $nast = $user->partner->nastavnik->username;
                if($user->partner->nastavnik->is_username == 1){
                    $nast = 'У пользователя нет Username';
                }
                $mass = "Тебя пригласил пользователь @".$nast."
".'Уровень 1 ('.$str->count().' рефералов):'."
";
            }else{
                $mass = 'Уровень 1 ('.$str->count().' рефералов):'."
";
            }
            $i = 0;
            foreach($str as $item){
                if($item->user->is_username == 0){

                    $mass .= '@'.$item->user->username." id ".$item->user->id."
";
                    $i++;
                    if($i == 50){
                        $mass .= 'К сожеления ваша первая линия больше 50 человек, телеграм не позволяет столько строк отображать, всех партнеров вы можете посмотреть в личном кабинете';
                        break;
                    }
                }
            }
        }
        return $mass;
    }
    public static function menu($req){
        $countUs = User::count();
        $user = User::where('id_telegram', $req)->first();
        $mass = "Пользователь не найден";
        if($user){
            $nast = 'Нет наставника';
            if($user->partner->nastavnik){
                $nast = $user->partner->nastavnik->username;
                if($user->partner->nastavnik->is_username == 1){
                    $nast = 'У пользователя нет Username';
                }
            }
            $status = "Free";
            $active = "Не активна";
            if($user->partnerThree){
                $status = $user->partnerThree->status()['status'];
                if($user->partnerThree->active == 1){
                    $active = "Активна";
                }
            }
$mass = $user->name.", Добро пожаловать в главное меню TRClub

🤖 В системе находятся ".$countUs." людей
📌 Ваш ID: ".$user->id."
😎 Пригласитель: @".$nast."
🔰 Текущий статус: ".$status."
🕓 Подписка: ".$active."
💰 Баланс: ".$user->balance->balance." (P.)
💸 Заработано: ".$user->balance->balance_work." (P.)

Пригласительная ссылка на твою реф воронку 

https://t.me/TRClub_bot?start=".$user->id."


Здесь ты можешь:
✅ Подключить и начать применять воронку, для продвижения своего бизнеса уже через 15 минут.
✅ Прокачать необходимые навыки для легкого заработка онлайн.
✅ Применяя воронку для продвижения своего бизнеса, зарабатывать 10ки и 100ни тысяч ежемесячно, на встроенной рефералке.";

        }
        return $mass;
    }
}