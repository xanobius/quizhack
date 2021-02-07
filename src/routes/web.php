<?php

use Illuminate\Support\Facades\Route;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

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
    return view('welcome');
});

Route::get('mod', function() {
    return view('moderator');
});


WebSocketsRouter::webSocket('/tryout', \App\SocketHandlers\TestSocketHandler::class);
WebSocketsRouter::webSocket('/player', \App\SocketHandlers\PlayerSocketHandler::class);
WebSocketsRouter::webSocket('/moderator', \App\SocketHandlers\ModeratorSocketHandler::class);
