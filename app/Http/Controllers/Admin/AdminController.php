<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\UpdateSistem;
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
        return view('admin.index', compact('countUser'));
    }
    public function active(Request $request){
        $key = $request->key;
        $result = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post('https://lidasite.ru/api/activeKey', ['site' => request()->getSchemeAndHttpHost(), 'keyActive'=>$key]);
        $otvet = $result->json();
        if($otvet['data']['string'] == 'Ключ активирован'){
            $apps = AppActive::find(1);
            if($otvet['data']['time'] == 1){
                $apps->indefinitely = 1;
            }
            $apps->key = $key;
            $apps->save();
        }
        return redirect()->route('admin.index')->with($otvet['data']['status'], $otvet['data']['string']);
        
    }
}