<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        try {
            $apiResponse = Http::post('https://lidasite/api/activeKey', ['site' => request()->getSchemeAndHttpHost()]); // Замените URL на ваш API

            $data = $apiResponse->json(); // предполагаем, что API возвращает JSON
            View::share('globalData', $data); // Сохраняем данные в шаред-данные
        } catch (\Exception $e) {
             // Обработка ошибки, например, логирование
            \Log::error("Error fetching API data: " . $e->getMessage());
            View::share('globalData', []); // Устанавливаем пустой массив, чтобы не было ошибок
        }
    }
}
