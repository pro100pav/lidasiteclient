<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bot\Bot;
use App\Models\User;
use App\Customs\ApiRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class BotsController extends Controller
{
    public function index(){
        $bots = Bot::all();
        return view('admin.bots.index',compact('bots'));
    }

    
    public function create(Request $request){
        if(View::getShared('globalData')['globalData']->bot <= Bot::count()){
            return redirect()->route('admin.bots.index');
        }
        if ($request->isMethod('post')){
            Bot::create([
                'name' => $request->name,
                'token' => $request->token,
                'type' => $request->type,
                'link' => $request->link,
            ]);
            return redirect()->route('admin.bots.index');
        }else{
            return view('admin.bots.create');
        }
        
    }

    public function edit(Request $request, $id){
        $bot = Bot::find($id);
        if ($request->isMethod('post')){
            $bot->name = $request->name;
            $bot->token = $request->token;
            $bot->link = $request->link;
            
            $bot->save();
            return redirect()->route('admin.bots.index');
        }else{
            return view('admin.bots.edit', compact('bot'));
        }
        
    }
    public function delete(Request $request, $id){
        $bot = Bot::find($id);
        $bot->delete();
        return redirect()->route('admin.bots.index');
    }
    
}
