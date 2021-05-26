<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
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
    //$user=\App\Models\User::get();
    //Notification::send($user,new App\Notifications\notifyproprietaire());

    /*$user=\App\Models\User::find(1);
    foreach($user->unreadnotifications as $not)
    {
        var_dump($not->data);
        //$not->markAsRead();
    }*/
});

Route::get('/send-email', [MailController::class,'sendEmail']);
Route::get('/show', [LocationController::class,'show']);
