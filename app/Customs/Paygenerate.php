<?php

namespace App\Customs;

use Auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\Billing;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Paygenerate{

    static public function  generate($summa, $user, $bot){
        
        $mrh_pass1 =  "x9c1Gml6Qanuqg88iyla"; // пароль #1

        $pay = Payment::create([
            'user_id'=> $user->id,
            'balance' => $summa,
            'description' => "пополнение (Р.)",
            'operation' => 'Пополнение',
            'status' => null,
            'type' => 0,
            'bot_id' => $bot,
        ]);
        $pay->uid = $pay->id;
        $pay->save();
        $receipt = array(
            'sno' => 'usn_income',
            'items' => array(
                array(
                'name' => 'Оплата_онлайн-сервиса_в_соответсвие_с_договором_офертой_https://lidasite.ru/oferta',
                "quantity" => 1.0,
                "sum" => $summa,
                "payment_method" => "full_payment",
                "payment_object" => "payment",
                "tax" => "none"
                )                    
            )
        );
        $encoded_receipt = json_encode($receipt, JSON_UNESCAPED_UNICODE);
        $params = array(
            'MerchantLogin' => 'lidasite',                // Идентификатор магазина
            'InvId'         => $pay->id,// ID заказа
            'Description'   => 'Оплата_онлайн-сервиса_в_соответсвие_с_договором_офертой_https://lidasite.ru/oferta', // Описание заказа (мах 100 символов)
            'OutSum'        => $summa,          // Сумма заказа
            'Culture'       => 'ru',   
            'Encoding'      => 'utf-8',
            'Receipt'      => urlencode( $encoded_receipt ),
        );

        // Формирование подписи
        $params['SignatureValue'] = md5("{$params['MerchantLogin']}:{$params['OutSum']}:{$params['InvId']}:$encoded_receipt:{$mrh_pass1}"); 
        $result = self::createHash();
        ShortLink::create([
            'link' => 'https://auth.robokassa.ru/Merchant/Index.aspx?' . urldecode(http_build_query($params)),
            'short' => $result,
            'click' => 0,
            'type' => 1,
        ]);

        // Перенаправляем пользователя на страницу оплаты
        return $result;
        
    }
    static public function createHash(){
        $str = Str::password(5, true, true, false, false);
        if(ShortLink::where('short', $str)->first()){
            $this->createHash();
        }
        
        return $str;
    }
}
