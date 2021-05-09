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
    Route::post('uploadimage', 'App\Http\Controllers\ProprietaireController@uploadimage');
    Route::get('countlocation', 'App\Http\Controllers\LocationController@countlocation');
    Route::get('countbien', 'App\Http\Controllers\BienController@countbien');
    Route::get('counlocataire', 'App\Http\Controllers\LocphController@counlocataire');
    Route::get('countproprietaire', 'App\Http\Controllers\ProprietaireController@countproprietaire');
    Route::get('getUserById/{id}', 'App\Http\Controllers\ProprietaireController@getUserById');
    Route::get('getchargeById/{id}', 'App\Http\Controllers\ChargeController@getchargeById');
    Route::get('getlocataireById/{id}', 'App\Http\Controllers\LocphController@getlocataireById');
    Route::put('archiverUser/{id}', 'App\Http\Controllers\LocphController@archiverUser');
    Route::put('update/{id}', 'App\Http\Controllers\ProprietaireController@update');
    Route::get('getbienById/{id}', 'App\Http\Controllers\BienController@getbienById');
    Route::get('getlocationById/{id}', 'App\Http\Controllers\LocationController@getlocationById');
    Route::put('archiverBien/{id}', 'App\Http\Controllers\BienController@archiverBien');
    Route::put('archiverLocation/{id}', 'App\Http\Controllers\LocationController@archiverLocation');
    Route::put('updatelocation/{id}', 'App\Http\Controllers\LocationController@updatelocation');
    Route::put('updatebien/{id}', 'App\Http\Controllers\BienController@updatebien');
    Route::put('updateMorale/{id}', 'App\Http\Controllers\SocieteController@updateMorale');
    Route::get('getBienLibre', 'App\Http\Controllers\BienController@getBienLibre');
    Route::get('biens', 'App\Http\Controllers\BienController@getBienLibreWithImages');
    Route::get('bie_prop/{idu}', 'App\Http\Controllers\ProprietaireController@bie_prop');
    Route::post('sendMailChangePass', 'App\Http\Controllers\ProprietaireController@mailChangerPass');
    Route::get('getImmoById/{id}', 'App\Http\Controllers\BienController@getImmoById');
    Route::get('search/{search}', 'App\Http\Controllers\ProprietaireController@search');
    Route::get('searchbien/{search}', 'App\Http\Controllers\BienController@searchbien');
    Route::get('searchcharge/{search}', 'App\Http\Controllers\ChargeController@searchcharge');
    //Route::get('Affnotification/{id}', 'App\Http\Controllers\ProprietaireController@Affnotification');
    Route::put('change_password/{id}', 'App\Http\Controllers\AuthController@change_password');
    Route::get('getUser/{id}', 'App\Http\Controllers\ProprietaireController@getUser');



});
