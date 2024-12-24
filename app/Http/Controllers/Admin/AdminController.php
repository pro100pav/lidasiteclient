<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\AppActive;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
class AdminController extends Controller
{
    public function index(Request $request){
        $countUser = User::count();
        $bot = Bot::find(1);
        $user = User::find(1);
        $usBot = $user->bots->where('bot_id', $bot->id)->first();
        dd($usBot);
        Artisan::call('migrate');
        return view('admin.index', compact('countUser'));
    }
    public function active(Request $request){
        $key = $request->key;
        $result = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post('https://lidasite.ru/api/activeKey', ['site' => request()->getSchemeAndHttpHost(), 'key'=>$key]);
        $otvet = $result->json();
        return redirect()->route('admin.index')->with($otvet['data']['status'], $otvet['data']['string']);
        
    }
}