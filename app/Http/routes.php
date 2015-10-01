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

// Public routes
Route::controller('auth', 'Auth\AuthController');

Route::get('/', function () {
    return redirect('auth/login');
});

// Private routes
Route::group(['middleware' => ['auth']], function(){
	Route::controller('product', 'ProductController');
	Route::controller('category', 'CategoryController');
	Route::controller('brand', 'BrandController');
	Route::controller('user', 'UserController');
	Route::controller('role', 'RoleController');
});

// Display all SQL executed in Eloquent
/*Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});*/