<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
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
        ])->post('https://lidasite/api/activeKey', ['site' => request()->getSchemeAndHttpHost(), 'key'=>$key]);
        $otvet = $result->json();
        return redirect()->route('admin.index')->with($otvet['data']['status'], $otvet['data']['string']);
        
    }
}