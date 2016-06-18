<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses' => 'SocialAuth@Login']);

Route::get('/Auth/Redirect/{provider}', ['uses' => 'SocialAuth@getSocialRedirect']);
Route::get('/Auth/Handle/{provider}', ['uses' => 'SocialAuth@getSocialHandle']);

Route::get('/Form', 'StoreDatabase@Form');
Route::post('/Form/Action', ['uses' => 'StoreDatabase@Store']);

Route::get('/Home', 'MSPController@Home');
Route::get('/Signout', 'MSPController@Signout');

// Route::get('/Create', ['uses' => 'TestAzure@MSPCreateTable']);
Route::get('/QueryDuckTiny', ['uses' => 'TestAzure@MSPQuery']);

//Route::get('/Admin', ['uses' => 'MSPController@adminGUI']);
//Route::post('/Admin', ['uses' => 'MSPController@adminProcessForm']);
// Route::get('/Seed', ['uses' => 'TestAzure@MSPSeed']);

// Route::get('/Auth/', ['uses' => 'SocialAuth@Google']);
// Route::get('/Auth/Microsoft', ['uses' => 'SocialAuth@Microsoft']);


