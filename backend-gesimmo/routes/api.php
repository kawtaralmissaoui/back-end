<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::get('index', 'App\Http\Controllers\AuthController@index');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('AddBien', 'App\Http\Controllers\BienController@AddBien');
    Route::post('AddProprietaire', 'App\Http\Controllers\ProprietaireController@AddProprietaire');
    Route::post('AddSociete', 'App\Http\Controllers\SocieteController@AddSociete');
    Route::post('addLocP', 'App\Http\Controllers\LocphController@addLocP');
    Route::post('addLocation', 'App\Http\Controllers\LocationController@addLocation');
    Route::post('addFacture', 'App\Http\Controllers\FactureController@addFacture');
    Route::post('addLocM', 'App\Http\Controllers\LocmoController@addLocM');
    Route::post('addCharge', 'App\Http\Controllers\ChargeController@addCharge');
    Route::post('addPaiement', 'App\Http\Controllers\PaiementController@addPaiement');
    Route::get('getLocPhyActif', 'App\Http\Controllers\LocphController@getLocPhyActif');
    Route::get('getLocPhyArchive', 'App\Http\Controllers\LocphController@getLocPhyArchive');
    Route::get('getProPhyActif', 'App\Http\Controllers\ProprietaireController@getProPhyActif');
    Route::get('getProPhyArchive', 'App\Http\Controllers\ProprietaireController@getProPhyArchive');
    Route::get('getBienActif', 'App\Http\Controllers\BienController@getBienActif');
    Route::get('getBienArchive', 'App\Http\Controllers\BienController@getBienArchive');
    Route::get('getLocationActif', 'App\Http\Controllers\LocationController@getLocationActif');
    Route::get('getLocationArchive', 'App\Http\Controllers\LocationController@getLocationArchive');
    Route::get('getChargeActif', 'App\Http\Controllers\ChargeController@getChargeActif');
    Route::get('getChargeArchive', 'App\Http\Controllers\ChargeController@getChargeArchive');







});
