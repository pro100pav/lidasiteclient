<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bot\Bot;
use App\Models\Bot\SocialGroup;
use App\Models\User;
use App\Customs\ApiRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GroupsController extends Controller
{
    public function index(Request $request){
        $groups = SocialGroup::all();
        return view('admin.group.groups',compact('groups'));
    }
    public function groupPodpis(Request $request, $id){
        $group = SocialGroup::find($id);
        if($group->podpiska == 1){
            $group->podpiska = 0;
            $group->save();
        }else{
            $group->podpiska = 1;
            $group->save();
        }
        return redirect()->back();
    }
    
}
