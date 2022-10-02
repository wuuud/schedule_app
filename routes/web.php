<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FullCalendarController;

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

// - Route::get('/', function () {
// -     return view('welcome');
// - });

Route::get('/', [EventController::class, 'index'])
    ->name('root')
    ->middleware('auth');

Route::middleware([
    'auth:sanctum',
    // 認証で使う機能
    config('jetstream.auth_session'),
    // メールアドレスの確認（土曜日にしたやつ）
    'verified'

    // groupでroutingを一纏めにする
    // 上記３行を通してからgroup以下をする
    // 認証に全て通ったデータだけrouteします！！！！
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD用
    Route::resource('events', EventController::class);

    // カレンダー用
    Route::get('calendar', function () {
        return view('full-calendar');
    })->name('calendar');

    // FullController用
    Route::get('calendar/action', [FullCalendarController::class, 'index']);
    Route::post('calendar/action', [FullCalendarController::class, 'action']);
});
