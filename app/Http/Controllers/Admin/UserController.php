<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserKey;
use App\Models\Ticket;
use App\Models\Key;
use App\Models\Billing;
use App\Models\UserBalance;
use App\Models\UserKeyOfUser;
use App\Models\Pool;
use App\Models\UserPool;
use App\Models\ClassicPartner;
use App\Models\Bot\Bot;
use App\Models\Bot\ChatUser;
use App\Models\Bot\ChatUserMessage;
use App\Models\Bot\Notice;
use App\Models\Bot\UserBot;
use App\Customs\Bot\BotCustomMethod;
use App\Customs\Referals;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{

    public function index(Request $request){
        $users = User::paginate(50);
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $query = User::query();
        $query->orderBy($sortField, $sortDirection);
        $users = $query->paginate(50);
        return view('admin.user.index', compact('users','sortField', 'sortDirection'));
    }

    public function show(Request $request, $id){
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }
    

    
    public function search(Request $request){
        
        if($request->type == 1){
            $user = User::find($request->id);
            if($user){
                return redirect()->route('admin.user.managerShow', $user->id);
            }
            return redirect()->back()->with('message', 'Не найден');
        }
        $users = null;
        if($request->type == 2){
            $users = User::where('username','LIKE', '%'.$request->username.'%')->get();
        }
        if($request->type == 3){
            $users = User::where('name','LIKE', '%'.$request->name.'%')->get();
        }
        
        return view('admin.user.search', compact('users'));
    }

    public function chats(Request $request, $id){
        $user = User::find($id);
        return view('admin.user.chats', compact('user'));
    }
    public function chat(Request $request, $chat){
        $chat = ChatUser::find($chat);
        $user = $chat->botUs->user;
        return view('admin.user.chat', compact('user','chat'));
    }
    
    
    public function setting(Request $request, $id){
        $userMan = User::find($id);
        if ($request->isMethod('post')){
            if($request->type == 1){
                $userMan->balance->balance += $request->summa;
                $userMan->balance->save();
                $billing = new Billing();
                $billing->balance_add = $request->summa;
                $billing->balance_off = 0;
                $billing->description = 'Покупка (LI.)';
                $billing->type = 0;
                $userMan->billing()->save($billing);
            }
            if($request->type == 2){
                $count = $request->count;
                $type = $request->key;
                $key = Key::where('type',$request->key)->first();
                $price = $key->price;
                
                $billing = new Billing();
                $billing->balance_add = 0;
                $billing->balance_off = $count * $price;
                $billing->description = 'Покупка ключа LidaSite';
                $userMan->billing()->save($billing);
                if($userMan->keys){
                    if($type == 1){
                        $userMan->keys_pay += $count;
                    }else{
                        $userMan->keys_year += $count;
                    }
                    $userMan->keys->count += $count;
                    $userMan->keys->save();
                }else{
                    $key = new UserKey();
                    $key->price_zakup = $price;
                    if($type == 1){
                        $key->keys_pay += $count;
                    }else{
                        $key->keys_year += $count;
                    }
                    $key->count = $count;
                    $userMan->keys()->save($key);
                }

                for ($n = 1; $n <= $request->count; $n++) {
                    $ticCount = Ticket::where('type', 2)->count();
                    $tic = new Ticket();
                    $tic->number = $ticCount + 1;
                    $tic->type = 2;
                    $userMan->tickets()->save($tic);
                }
                if($type == 1){
                    $key->price += $count * 10;
                    $key->save();
                }else{
                    $key->price += $count;
                    $key->save();
                }
                
                $refer = $userMan->partner->nastavnik;
                if($refer->keys){
                    $ofKey = UserKeyOfUser::where([['user_send_id', $userMan->id],['user_reception_id',$refer->id],['type',$type]])->first();
                    if($ofKey){
                        if($refer->keys->keys_pay - $ofKey->count != 0){
                            $nachislit = $request->count;
                            if($request->count > $refer->keys->keys_pay - $ofKey->count){
                                $nachislit = $refer->keys->keys_pay - $ofKey->count;
                            }
                            $refer->keys->count += $nachislit;
                            $refer->keys->save();
                            $ofKey->count += $nachislit;
                            $ofKey->save();
                            Notice::create([
                                'user_id' => $refer->id,
                                'text' => 'Ключей начислено по бонусной программе: '.$nachislit,
                                'send' => 0,
                            ]);
                            $billing = new Billing();
                            $billing->balance_add = 0;
                            $billing->balance_off = 0;
                            $billing->description = 'Ключей начислено по бонусной программе: '.$nachislit. 'От '.$userMan->name;
                            $refer->billing()->save($billing);
                            for ($n = 1; $n <= $nachislit; $n++) {
                                $ticCount1 = Ticket::where('type', 2)->count();
                                $tic1 = new Ticket();
                                $tic1->number = $ticCount1 + 1;
                                $tic1->type = 2;
                                $refer->tickets()->save($tic1);
                            }
                        }
                    }else{
                        $nachislit = $request->count;
                        if($request->count >= $refer->keys->keys_pay){
                            $nachislit = $refer->keys->keys_pay;
                        }
                        UserKeyOfUser::create([
                            'user_send_id' => $userMan->id,
                            'user_reception_id' => $refer->id,
                            'count' => $nachislit,
                            'type' => $type,
                        ]);
                        Notice::create([
                            'user_id' => $refer->id,
                            'text' => 'Ключей начислено по бонусной программе: '.$nachislit,
                            'send' => 0,
                        ]);
                        $billing = new Billing();
                        $billing->balance_add = 0;
                        $billing->balance_off = 0;
                        $billing->description = 'Ключей начислено по бонусной программе: '.$nachislit. 'От '.$userMan->name;
                        $refer->billing()->save($billing);
                        for ($n = 1; $n <= $nachislit; $n++) {
                            $ticCount1 = Ticket::where('type', 2)->count();
                            $tic1 = new Ticket();
                            $tic1->number = $ticCount1 + 1;
                            $tic1->type = 2;
                            $refer->tickets()->save($tic1);
                        }
                    }
                    
                }
                Notice::create([
                    'user_id' => $id,
                    'text' => 'Ключей начислено: '.$request->summa,
                    'send' => 0,
                ]);
            }
            if($request->type == 3){
                $pool = Pool::find($request->pool);
                $poolN = new UserPool();
                $poolN->pool_id = $pool->id;
                $poolN->pay = $pool->price;
                $userMan->pool()->save($poolN);
                $billing = new Billing();
                $billing->balance_add = 0;
                $billing->balance_off = $pool->price;
                $billing->description = 'Участие в: '.$pool->name;
                $userMan->billing()->save($billing);
                Notice::create([
                    'user_id' => $id,
                    'text' => 'Вы приняли участие: '.$pool->name."\n".$pool->description,
                    'send' => 0,
                ]);
            }
            if($request->type == 4){
                $userMan->blocked = 1;
                $userMan->save();
            }
            return redirect()->route('admin.user.managerShow', $userMan->id);
        }else{
            return redirect()->route('admin.user.managerShow', $userMan->id);
        }
        
    }
    public function sendMessage(Request $request, $id){
        $userTeleg = UserBot::where('user_id',$id)->first();
        $param = [
                'chat_id' => $userTeleg->user->id_telegram,
                'text' => $request->comment,
                'parse_mode' => 'MarkDown',
            ];
        $res = BotCustomMethod::index('sendMessage', $param, $userTeleg->bot->token);
        return redirect()->back()->with('success', 'Сообщение отправлено');
    }
    public function chatSend(Request $request, $id, $chat){
        $userTeleg = UserBot::where('user_id',$id)->first();
        $chat = ChatUser::find($chat);
        if($chat->close == 1){
            return redirect()->back()->with('danger', 'Диалог закрыт');
        }
        $mesUser = new ChatUserMessage();
        $mesUser->message_bot = $request->message;
        $chat->messages()->save($mesUser);

        $param = [
                'chat_id' => $userTeleg->id_telegram,
                'text' => $request->message,
                'parse_mode' => 'MarkDown',
            ];
        $res = BotCustomMethod::index('sendMessage', $param, $userTeleg->bot->token);
        return redirect()->back()->with('success', 'Сообщение отправлено');
    }

}