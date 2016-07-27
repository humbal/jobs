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

//Route::group(['middleware'=>['web']], function () {
    Route::get('/job/search', ['as'=>'search', 'uses'=>'JobSearchController@search']);
    Route::get('/', 'JobSearchController@search');


    Route::get('/login','Auth\AuthController@getLogin');
    Route::post('/login','Auth\AuthController@authenticate');
    Route::get('/logout','Auth\AuthController@logout');

    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@register');
    Route::get('register/email/verify/{confirmation_code}', ['as'=>'auth.email.verify','uses' => 'Auth\AuthController@confirmEmail']);
//});
//Route::auth();

Route::group(['middleware'=>['auth','web']], function () {

    Route::get('/home', 'HomeController@index');

    Route::get('/skills', 'SkillsController@skills_show');
    Route::post('/addskills', 'SkillsController@skills_add');

    Route::get('/editSkill/{id}', 'SkillsController@skills_edit');
    Route::post('/updateSkill/{id}', 'SkillsController@skills_update');
    Route::get('/deleteSkill/{id}', 'SkillsController@destroy');


    Route::get('jobpost/index', 'JobPostController@index');
    Route::get('jobpost/edit/{auth_id}', ['as' => 'job-edit', 'uses' => 'JobPostController@edit']);
    Route::post('jobpost/update/{auth_id}', ['as' => 'update-job', 'uses' => 'JobPostController@update']);
    Route::get('jobpost/delete/{auth_id}', ['as' => 'job-delete', 'uses' => 'JobPostController@destroy']);

    Route::get('jobpost/index', 'JobPostController@index');
    Route::get('jobpost/edit/{auth_id}', ['as' => 'job-edit', 'uses' => 'JobPostController@edit']);
    Route::post('jobpost/update/{auth_id}', ['as' => 'update-job', 'uses' => 'JobPostController@update']);
    Route::get('jobpost/delete/{auth_id}', ['as' => 'job-delete', 'uses' => 'JobPostController@destroy']);

    Route::get('jobpost', 'JobPostController@create');
    Route::post('jobpost', 'JobPostController@store');
});