<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('index');
Route::post('/auth', [App\Http\Controllers\FrontController::class, 'auth'])->name('auth');
Route::get('/activated', [App\Http\Controllers\FrontController::class, 'activated'])->name('activated');

Route::middleware(['auth','redirect.if'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard.index');
    });
});

Route::middleware(['auth','admin','redirect.if'])->name('admin.')->prefix('manager')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
    Route::post('/active', [App\Http\Controllers\Admin\AdminController::class, 'active'])->name('active');
    Route::get('/update', [App\Http\Controllers\Admin\UpdateController::class, 'updateGet'])->name('updateGet');
    Route::post('/update', [App\Http\Controllers\Admin\UpdateController::class, 'update'])->name('update');
    Route::prefix('users')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
        Route::post('/search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('user.search');
        Route::get('/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('user.show');
        Route::get('user/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('user.show');
        Route::get('/{id}/chats', [App\Http\Controllers\Admin\UserController::class, 'chats'])->name('user.chats');
        Route::get('/chat/{chat}', [App\Http\Controllers\Admin\UserController::class, 'chat'])->name('user.chat');
        Route::post('/chat/{chat}', [App\Http\Controllers\Admin\UserController::class, 'chatSend'])->name('user.chatSend');
    });
    Route::prefix('groups')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GroupsController::class, 'index'])->name('groups.index');
        Route::get('/podpis/{id}', [App\Http\Controllers\Admin\GroupsController::class, 'groupPodpis'])->name('groups.groupPodpis');
    });
    Route::prefix('bots')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BotsController::class, 'index'])->name('bots.index');
        Route::get('/create', [App\Http\Controllers\Admin\BotsController::class, 'create'])->name('bots.create');
        Route::post('/create', [App\Http\Controllers\Admin\BotsController::class, 'create'])->name('bots.create');
        Route::match(['get', 'post'],'/edit/{id}', [App\Http\Controllers\Admin\BotsController::class, 'edit'])->name('bots.edit');
        Route::get('/delete/{id}', [App\Http\Controllers\Admin\BotsController::class, 'delete'])->name('bots.delete');
    });
    
    
    Route::prefix('bottemplates')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BotConstructController::class, 'index'])->name('botconstr.index');
        Route::post('/template/create', [App\Http\Controllers\Admin\BotConstructController::class, 'templateCreate'])->name('botconstr.templateCreate');
        Route::get('/template/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'templateShow'])->name('botconstr.templateShow');
        Route::get('/templateActivate/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'templateActivate'])->name('botconstr.templateActivate');
        Route::match(['get', 'post'],'/editTemplate/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'editTemplate'])->name('botconstr.editTemplate');
        Route::get('/templateDel/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'deleteTemplate'])->name('botconstr.deleteTemplate');

        Route::post('/messageButton/create', [App\Http\Controllers\Admin\BotConstructController::class, 'messageButtonCreate'])->name('botconstr.messageButtonCreate');

        Route::post('/message/create/{temp}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageCreate'])->name('botconstr.messageCreate');
        Route::get('/message/edit/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageEdit'])->name('botconstr.messageEdit');
        Route::post('/message/edit/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageEditSave'])->name('botconstr.editMessage');
        Route::get('/message/delete/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageDelete'])->name('botconstr.messageDelete');

        Route::get('/messageButton/delete/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageButtonDelete'])->name('botconstr.messageButtonDelete');

        Route::post('/messageItem/create/{message}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageItemCreate'])->name('botconstr.messageItemCreate');
        Route::get('/messageItem/edit/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageItemEdit'])->name('botconstr.messageItemEdit');
        Route::post('/messageItem/save/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageItemEditSave'])->name('botconstr.messageItemEditSave');
        Route::get('/messageItem/delete/{id}', [App\Http\Controllers\Admin\BotConstructController::class, 'messageItemDelete'])->name('botconstr.messageItemDelete');

        Route::post('/message/upload/photo', [App\Http\Controllers\Admin\BotConstructController::class, 'uploadPhoto']);
        Route::post('/message/upload/video', [App\Http\Controllers\Admin\BotConstructController::class, 'uploadVideo']);
        Route::post('/message/upload/noticevideo', [App\Http\Controllers\Admin\BotConstructController::class, 'uploadnoticevideo']);
        Route::post('/message/delete/file', [App\Http\Controllers\Admin\BotConstructController::class, 'deleteFile']);
        Route::post('/template/delete/file', [App\Http\Controllers\Admin\BotConstructController::class, 'deleteFileTemp']);
    });
    Route::prefix('rassilki')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\RassilkiController::class, 'index'])->name('rassilka.index');
        Route::post('/create', [App\Http\Controllers\Admin\RassilkiController::class, 'create'])->name('rassilka.create');
        Route::post('/createTest', [App\Http\Controllers\Admin\RassilkiController::class, 'createTest'])->name('rassilka.createTest');
    });
    Route::prefix('sendTelegramCustom')->group(function () {
        Route::post('/sendmessageuser/{id}', [App\Http\Controllers\Admin\UserController::class, 'sendMessage'])->name('sendmessage.userTelega');
    });
});

Route::post('/bots/{id}',[App\Http\Controllers\Telegram\BotsController::class, 'index']);

Route::fallback(function (){
    abort(404);
});