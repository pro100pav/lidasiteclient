<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\ClassicPartner;
use App\Models\Billing;
use App\Models\Key;
use App\Models\Bot\Bot;
use App\Customs\Bot\BotCustomMethod;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request){
        $bots = Bot::where('public', 1)->get();

        return view('dashboard.partner.index', compact('bots'));
    }
    public function structura(Request $request, $id){
        $bot = Bot::find($id);
        $user = Auth::user();
        $reCount = $this->treeCountLvl($user->id, $id);

        return view('dashboard.partner.structura', compact('bot','reCount'));
    }
    public function structuraJSON(Request $request, $id){
        $user = Auth::user();
        $result = [];
        $partners = ClassicPartner::where([['bot_id', $id],['user_id', $user->id]])->with('partner')->get();
        $re = $this->tree2array($partners, $user->id, $result);
        return response()->json($re);
    }

    function tree2array($tree, $userID, &$result) {
        $i = 0;
        foreach( $tree as $node ) {
            $parent = $node->refer_id;
            if($node->user_id == $userID){
                $parent = null;
            }
            $infus = [
                'customId'=> $node->user_id,
                'customParentId'=>$parent,
                'name'=> $node->user->name,
            ];
            array_push($result, $infus);
            $i++;
            
            if ($node->childrenPartners){
                $this->tree2array($node->childrenPartners, $userID, $result);
            }
        }
        return $result;
    }
    function treeCountLvl($userID, $botId) {
        $user = Auth::user();
        $result = [];
        $result2 = [];
        $result3 = [];
        $countpart = $this->treeCount(ClassicPartner::where([['bot_id', $botId],['user_id', $userID]])->with('partner')->get(), $result);

        $numbers = array_column($countpart, 'lvl');
        $max = max($numbers);
        $i=0;
        $countlvl = [];
        for ($n = 0; $n <= $max; $n++) {
            $res = $this->searchForId($n, $countpart);
            array_push($countlvl, ['lvl'=>$n+1,  'coutn'=>$res]);
        }
        return ['partner' => count($countpart), 'lvlcount'=> $countlvl];
    }
    function treeCount($tree, &$result, $i = 0) {
        foreach( $tree as $node ) {
            if ($node->childrenPartners){
                $id = array_search($node->refer_id, array_column($result, 'pid'));
                if($id > 0){
                    array_push($result, ['id'=>$node->user_id,  'coutn'=>$node->childrenPartners->count(), 'pid'=>$node->refer_id, 'lvl'=> $result[$id]['lvl']]);
                }else{
                    array_push($result, ['id'=>$node->user_id,  'coutn'=>$node->childrenPartners->count(), 'pid'=>$node->refer_id, 'lvl'=> $i++]);
                }
                $this->treeCount($node->childrenPartners, $result, $i);
            }
        }
        return $result;
    }
    function searchForId($id, $array) {
        $count = 0;
        foreach ($array as $key => $val) {
            if ($val['lvl'] === $id) {
                $count += $val['coutn'];
            }
        }
        return $count;
    }
}
