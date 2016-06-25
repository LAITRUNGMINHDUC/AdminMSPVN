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

//Chart pages --> New, Reject,...
Route::get('/Manage', ['uses' => 'ManageController@Home']);

//Process Pages
Route::get('/Manage/InProgress', ['uses' => 'ManageController@listInProgress']);
Route::put('/Manage/InProgress', ['uses' => 'ManageController@listConfirm']);

Route::get('/Manage/Processed', ['uses'=>'ManageController@listProcessed']);
Route::get('/Manage/Processed/{DateID}', ['uses' => 'ManageController@listDownload']);

Route::get('Email/InProgress/{ID}', ['uses'=>'MailController@sendInProgress']);

//Route::get('Azure/DeleteAndCreate', ['uses' => 'ManageController@deleteAndCreate']);
//Route::get('Azure/Init', ['uses' => 'ManageController@initVariables']);
//Mail
//Route::get('/Mail', ['uses' => '']);
