<?php

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



Auth::routes();

Route::get('/', 'BlogsIndexController@index');
Route::get('/test', 'DashboardController@index');
Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {

Route::get('dashboard', 'BlogsController@index')->name('dashboard.index');
// Blog Route
Route::get('blogs', 'BlogsController@index')->name('blog.index');
Route::get('/blogs/new', 'BlogsController@form')->name('blog.new');
Route::get('/blogs/{blog}', 'BlogsController@form')->name('blog.form');
Route::post('/blogs/save', 'BlogsController@post')->name('blog.save');
Route::post('/blogs/{blog}/delete', 'BlogsController@delete')->name('blog.delete');
Route::post('/blogs/{blog}/restore', 'BlogsController@restore')->name('blog.restore');
Route::post('/blogs/{blog}/force-delete', 'BlogsController@forceDelete')->name('blog.force-delete');

// Category Route
Route::get('categories', 'CategoriesController@index')->name('category.index');
Route::get('/categories/new', 'CategoriesController@form')->name('category.new');
Route::get('/categories/{category}', 'CategoriesController@form')->name('category.form');
Route::post('/categories/save', 'CategoriesController@post')->name('category.save');
Route::post('/categories/{category}/delete', 'CategoriesController@delete')->name('category.delete');
Route::post('/categories/{category}/restore', 'CategoriesController@restore')->name('category.restore');
Route::post('/categories/{category}/force-delete', 'CategoriesController@forceDelete')->name('category.force-delete');

});
