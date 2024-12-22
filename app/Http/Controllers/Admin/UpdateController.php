<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function update(Request $request)
    {
        try {
            // Проверка авторизации (опционально, если требуется)
            // Вызов Artisan команды для обновления
            $result = Artisan::call('git:pull'); // Или имя вашей команды
            dd($result);
            return response()->json(['message' => 'Обновление запущено!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}