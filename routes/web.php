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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){
	Route::get('/home', 'HomeController@index')->name('home');

	//administración
	//Categorías de productos
	Route::get('/admin/categories/create', 'CategoriesController@create')->name('categories_create');
	Route::post('/admin/categories/store', 'CategoriesController@store')->name('categories_store');
	Route::post('/admin/categories/{category}/delete', 'CategoriesController@destroy')->name('categories_delete');
	Route::get('/admin/categories', 'CategoriesController@index')->name('categories_index');
	
	//productos
	Route::get('/admin/products/create', 'ProductsController@create')->name('products_create');
	Route::post('/admin/products/store', 'ProductsController@store')->name('products_store');
	Route::post('/admin/products/{product}/delete', 'ProductsController@delete')->name('products_delete');
	Route::get('/admin/products', 'ProductsController@index')->name('products_index');
	
	//motivos de devolución
	Route::get('/admin/reasons/create', 'ReasonsController@create')->name('reasons_create');
	Route::post('/admin/reasons/store', 'ReasonsController@store')->name('reasons_store');
	Route::post('/admin/reasons/{reason}/delete', 'ReasonsController@destroy')->name('reasons_delete');
	Route::get('/admin/reasons', 'ReasonsController@index')->name('reasons_index');
	
	//preguntas
	Route::get('/admin/questions/create', 'QuestionsController@create')->name('questions_create');
	Route::post('/admin/questions/store', 'QuestionsController@store')->name('questions_store');
	Route::post('/admin/questions/{question}/delete', 'QuestionsController@destroy')->name('questions_delete');
	Route::get('/admin/questions', 'QuestionsController@index')->name('questions_index');
	
	//clientes
	Route::get('/add-to-order/', 'ProductsController@addProductToOrder')->name('products_add_to_order');
	Route::post('/my-shopping-cart/remove/{product}', 'ProductsController@removeFromOrder')->name('products_remove_from_order');
	Route::post('/my-shopping-cart/confirm', 'ProductsController@createOrder')->name('products_create_order');
	Route::get('/my-shopping-cart/', 'ProductsController@shoppingCart')->name('products_shopping_cart');
	
});	
