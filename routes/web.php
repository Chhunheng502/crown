<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrivateMsgController;
use App\Http\Controllers\UserController;
use App\Models\Friendship;
use App\Models\PrivateMsg;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('auth.loginForm');
});

Route::get('/login/form', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::resource('user', UserController::class);

Route::get('/home', function () {

    return view('home');

})->name('home');

Route::get('/chat-box', [PrivateMsgController::class, 'index'])->name('chat.index');
Route::get('/chat-box/messages', [PrivateMsgController::class, 'fetchMessages'])->name('chat.fetch');
Route::post('/chat-box/messages', [PrivateMsgController::class, 'sendMessage'])->name('chat.send');
