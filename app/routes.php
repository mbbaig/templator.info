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

Route::get('/', 'TemplatesController@getIndex');

Route::get('hello', function()
{
	return View::make('hello');
});

Route::get('about', function()
{
	return View::make('about');
});

Route::get('faq', function()
{
	return View::make('faq');
});

route::post("/tasks/create", "TasksController@postCreate");
route::post("/tasks/update", "TasksController@postUpdate");

Route::controller('users', 'UsersController');
Route::controller('categories', 'CategoriesController');
Route::controller('subcategories', 'SubcategoriesController');
Route::controller('templates', 'TemplatesController');
Route::controller('tasks', 'TasksController');
