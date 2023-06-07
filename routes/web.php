<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/sendemail', [EmailController::class, 'sendEmail']);

Auth::routes([
    'verify'=>true
]);


// Route::get('chat', 'ChatController@index');
// Route::get('messages', 'ChatController@fetchMessages');
// Route::post('messages', 'ChatController@sendMessage');

