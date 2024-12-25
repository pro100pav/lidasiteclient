<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\AddsPost;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;


class RassilkiController extends Controller
{

    public function index(Request $request){
        $bots = Bot::all();
        $posts = AddsPost::where('status','>',0)->latest()->paginate(10);
        return view('admin.bots.rassilka', compact('bots','posts'));
    }
    public function create(Request $request){
        if($request->button){
            if(!strstr($request->button, 'https://')){
                return redirect()->back()->with('danger', 'Ссылка должна обязательно быть с https:// в начале');
            }
        }
        AddsPost::create([
            'bot_id' => $request->bot,
            'message' => $request->messageras,
            'images' => $request->photomessage,
            'video' => $request->videomessage,
            'buttons' => $request->button,
            'send' => 0,
            'status' => 2,
        ]);
        return redirect()->back();
    }
    public function startRas(Request $request, $id){
        $post = AddsPost::find($id);
        $post->status = 4;
        $post->save();
        return redirect()->back();
    }


}