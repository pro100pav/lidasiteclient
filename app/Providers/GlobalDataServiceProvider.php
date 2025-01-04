<?php

namespace App\Providers;

use App\Models\AppActive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        App::booted(function (){ 

            $appa = AppActive::find(1);
            if($appa){
                
                if ($appa->updated_at->diffInHours(Carbon::now()) >= 1) {
                    try {
                        $apiResponse = Http::post('https://lidasite.ru/api/activeKey', ['site' => request()->getSchemeAndHttpHost(), 'key' => $appa->key]); // Замените URL на ваш API
                        $data = $apiResponse->json(); // предполагаем, что API возвращает JSON
    
                        $appa->indefinitely = $data['data']['indefinitely'];
                        $appa->active_at = $data['data']['active_at'];
                        $appa->bot = $data['data']['bot_count'];
                        $appa->save();
                        View::share('globalData', $appa); // Сохраняем данные в шаред-данные
                    } catch (\Exception $e) {
                         // Обработка ошибки, например, логирование
                        \Log::error("Error fetching API data: " . $e->getMessage());
                        View::share('globalData', []); // Устанавливаем пустой массив, чтобы не было ошибок
                    }
                }else{
                    View::share('globalData', $appa);
                }
            }else{
                
                try {
                    $apiResponse = Http::post('https://lidasite.ru/api/activeKey', ['site' => request()->getSchemeAndHttpHost()]); // Замените URL на ваш API
                    $data = $apiResponse->json(); // предполагаем, что API возвращает JSON
                    $appa = AppActive::create([
                        'indefinitely' => $data['data']['indefinitely'],
                        'active_at' => $data['data']['active_at'],
                        'bot' => $data['data']['bot_count'],
                        ]);
                    View::share('globalData', $appa); // Сохраняем данные в шаред-данные
                } catch (\Exception $e) {
                     // Обработка ошибки, например, логирование
                    \Log::error("Error fetching API data: " . $e->getMessage());
                    View::share('globalData', []); // Устанавливаем пустой массив, чтобы не было ошибок
                }
            }
        });
        
        
    }
}
