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
        if(!$chat){
            return redirect()->back()->with('message', 'Не найден чат');
        }
        $user = $chat->botUs->user;
        return view('admin.user.chat', compact('user','chat'));
    }
    
    
    public function setting(Request $request, $id){
        $userMan = User::find($id);
        
        return redirect()->route('admin.user.managerShow', $userMan->id);
        
        
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