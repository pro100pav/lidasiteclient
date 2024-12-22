<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function index(Request $request){
        return redirect()->route('login');
    }
    
    public function auth(Request $request){
        $userAdmin = User::find(1);
        if($userAdmin->code_auth == null){
            $userAdmin->code_auth = $request->code;
            $userAdmin->save();
        }
        $user = User::where('code_auth', $request->code)->first();
        if($user){
            Auth::login($user, $request->get('remember'));
            $request->session()->regenerate();
            return redirect()->route('admin.index');
        }else{
            return redirect()->back()->with('danger', 'Неверный код');
        }
    }
    public function activated(Request $request){
        return view('front.activated');
    }
    
}
