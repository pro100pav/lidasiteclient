<?php

namespace App\Customs;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pool;
use App\Models\UserPool;
use App\Models\UserBalance;
use App\Models\ClassicPartner;
use App\Models\Billing;
use App\Models\UserKey;
use App\Models\UserToken;
use App\Models\Bot\Bot;
use App\Models\Bot\Notice;
use Illuminate\Http\Request;

class Referals{
    static public function referals($user, $botId, $price){
        $struktura = $user->breadcrumbspartner($botId);
        $i = 1;
        $itogo = 0;
        foreach($struktura as $item){
            $refer = $item->user;
            $summa = 0;
            if($i == 1){
                $summa = $price / 100 * 5;
            }
            if($i == 2){
                $summa = $price / 100 * 10;
            }
            if($i == 3){
                $summa = $price / 100 * 20;
            }
            if($i < 4){
                $refer->balance->balance_work += $summa;
                $refer->balance->save();
                Notice::create([
                    'bot_id' => $botId,
                    'user_id' => $refer->id,
                    'text' => 'Бонус партнерского вознаграждения: '.$summa. ' От '.$user->name,
                    'send' => 0,
                ]);
                $billing = new Billing();
                $billing->balance_add = $summa;
                $billing->balance_off = 0;
                $billing->description = 'Бонус партнерского вознаграждения: '.$summa. ' От '.$user->name;
                $billing->type = 6;
                $refer->billing()->save($billing); 
                $itogo += $summa;
            }
            $i++;
        }

        return $itogo;
    }
    static public function visitRef($user, $price, $botId){
        $struktura = $user->breadcrumbspartner($botId);
        $i = 1;
        $itogo = 0;
        foreach($struktura as $item){
            $refer = $item->user;
            if($refer->product->where('active', 1)->where('product_id', 1)->sum('count') > 0){
                $summa = 0;
                if($i == 1){
                    $summa = $price / 100 * 5;
                }
                if($i == 2){
                    if($refer->product->where('active', 1)->where('product_id', 1)->sum('count') > 4){
                        $summa = $price / 100 * 10;
                    }else{
                        $summa = $price / 100 * 5;
                    }
                }
                if($i == 3){
                    if($refer->product->where('active', 1)->where('product_id', 1)->sum('count') > 4){
                        $summa = $price / 100 * 20;
                    }else{
                        $summa = $price / 100 * 5;
                    }
                }
                if($i < 4){
                    if($summa != 0){
                        $refer->balance->balance_work += $summa;
                        $refer->balance->save();
                        Notice::create([
                            'bot_id' => $botId,
                            'user_id' => $refer->id,
                            'text' => 'Бонус партнерского вознаграждения: '.$summa. ' От '.$user->name,
                            'send' => 0,
                        ]);
                        $billing = new Billing();
                        $billing->balance_add = $summa;
                        $billing->balance_off = 0;
                        $billing->description = 'Бонус партнерского вознаграждения: '.$summa. ' От '.$user->name;
                        $billing->type = 6;
                        $refer->billing()->save($billing); 
                        $itogo += $summa;
                    }
                }
            }
            $i++;
        }

        return $itogo;
    }
    static public function pools($botId, $price){
        $pool = Pool::where('bot_id', $botId)->first();
        if($pool){
            $users = $pool->users;
            $i = 1;
            $itogo = 0;
            $proc = $price / 2;
            $summa = $proc / 100 * 1;
            foreach($users as $userP){
                $user = $userP->user;
                
                
                $user->balance->balance_work += $summa;
                $user->balance->save();
                Notice::create([
                    'bot_id' => $botId,
                    'user_id' => $user->id,
                    'text' => 'Бонус в '.$pool->name.': '.$summa,
                    'send' => 0,
                ]);
                $billing = new Billing();
                $billing->balance_add = $summa;
                $billing->balance_off = 0;
                $billing->description = 'Бонус в '.$pool->name;
                $billing->type = 6;
                $user->billing()->save($billing); 
                $itogo += $summa;
                
                $i++;
            }
            return $itogo;
        }
        return 0;

        
    }
    static public function dolifive($price,$botId){
        $pool = UserPool::where('pool_id', 2)->get();
        if($pool->count() > 0){
            $summa = $price / 100 * 5;
            $kazhdomu = $summa / $pool->count();
            foreach($pool as $us){
                $user = $us->user;
                $user->balance->balance_work += $kazhdomu;
                $user->balance->save();
                Notice::create([
                    'bot_id' => $botId,
                    'user_id' => $user->id,
                    'text' => 'Бонус Партнерский фонд 5%: '.$kazhdomu,
                    'send' => 0,
                ]);
                $billing = new Billing();
                $billing->balance_add = $kazhdomu;
                $billing->balance_off = 0;
                $billing->description = 'Бонус Партнерский фонд 5%';
                $billing->type = 6;
                $user->billing()->save($billing); 
            }
        }
        return 0;
    }
    static public function doliten($price,$botId){
        $pool = UserPool::where('pool_id', 3)->get();
        if($pool->count() > 0){
            $summa = $price / 100 * 10;
            $kazhdomu = $summa / $pool->count();
            foreach($pool as $us){
                $user = $us->user;
                $user->balance->balance_work += $kazhdomu;
                $user->balance->save();
                Notice::create([
                    'bot_id' => $botId,
                    'user_id' => $user->id,
                    'text' => 'Бонус Партнерский фонд 10%: '.$kazhdomu,
                    'send' => 0,
                ]);
                $billing = new Billing();
                $billing->balance_add = $kazhdomu;
                $billing->balance_off = 0;
                $billing->description = 'Бонус Партнерский фонд 10%';
                $billing->type = 6;
                $user->billing()->save($billing); 
            }
        }
        return 0;
    }
    static public function dolitenLi($price,$botId){
        $pool = UserPool::where('pool_id', 4)->get();
        if($pool->count() > 0){
            $li = 0;
            foreach($pool as $liu){
                $li += $liu->user->tokenLi->sum('count');
            }
            $summa = $price / 100 * 10;
            $nachislit = $summa / $li;

            foreach($pool as $us){
                $user = $us->user;
                $usLi = $user->tokenLi->sum('count');
                $itg = $usLi * $nachislit;
                $user->balance->balance_work += $itg;
                $user->balance->save();
                Notice::create([
                    'bot_id' => $botId,
                    'user_id' => $user->id,
                    'text' => 'Бонус общего фонда Li: '.$itg,
                    'send' => 0,
                ]);
                $billing = new Billing();
                $billing->balance_add = $itg;
                $billing->balance_off = 0;
                $billing->description = 'Бонус общего фонда Li';
                $billing->type = 6;
                $user->billing()->save($billing); 
            }
        }
        return 0;
    }
}