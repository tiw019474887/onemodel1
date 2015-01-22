<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Blade::setContentTags('<%', '%>'); 		// for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); 	// for escaped data

Route::get('/', function()
{
    return Redirect::to('admin/home/');});

Route::get('/login','UserController@showLogin');
Route::post('/login','UserApiController@postLogin');


//only login can access

Route::group(array('before' => 'auth'), function(){

    Route::get('admin',function(){
        return Redirect::to('admin/home/');
    });

    Route::controller('admin/home/','AdminHomeController');
    Route::controller('admin/user','UserController');
    Route::controller('admin/researcher','ResearcherController');
    Route::controller('admin/faculty','FacultyController');
    Route::controller('admin/api','ApiController');
    Route::controller('admin/research-project','ResearchProjectController');
    Route::controller('admin/api','ApiController');
    Route::controller('admin/news','NewsController');


    Route::controller('api/users','UserApiController');
    Route::controller('api/researchers','ResearcherApiController');
    Route::controller('api/research-projects','ResearchProjectApiController');
    Route::controller('api/faculties','FacultyApiController');
    Route::controller('api/apis','ApiApiController');
    Route::controller('api/news','NewsApiController');

    Route::get('/logout','UserController@showLogout');
    Route::get('/current-user','UserApiController@getCurrentUser');

});



