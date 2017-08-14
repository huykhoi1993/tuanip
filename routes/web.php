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

Route::get('users/{id}', function() {
    //
});

// Admin
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',function(){
    	return view('admin.components.template');
    });

    // Route::get('/product', function() {
    // 	return view('admin.products');
    // });

    // San pham
    Route::group(['prefix' => 'product'], function(){
    	Route::get('/', 'ProductController@index');
    	Route::get('/create', 'ProductController@create');
    });

    // Danh muc san pham
    Route::group(['prefix' => 'category'], function(){
    	Route::get('/', 'CategoryController@index')->name('categories.index');
    	Route::post('/', 'CategoryController@store')->name('categories.store');
        Route::get('/categoryname', 'CategoryController@getCategoryName')->name('categoryname');
        Route::get('/categories', 'CategoryController@getCategories')->name('categories');;
        Route::post('/{id}/delete', 'CategoryController@removeCategory')->name('categories.delete');
        Route::post('/{id}', 'CategoryController@updateCategory')->name('categories.update');
    });

    Route::group(['prefix' => 'product'], function(){
        Route::get('/', 'ProductController@index')->name('products.index');
        Route::post('/', 'ProductController@store')->name('products.store');
        Route::post('/products', 'ProductController@getProducts')->name('products');
        Route::get('/productsname', 'ProductController@getProductsName')->name('productsname');
        Route::post('/{id}/delete', 'ProductController@deleteProduct')->name('products.delete');
        Route::post('/{id}', 'ProductController@updateProduct')->name('products.update');
    });

    Route::group(['prefix' => 'user'], function(){
        Route::get('/', 'UserController@index')->name('users.index');
        Route::post('/', 'UserController@store')->name('users.store');
        Route::post('/{id}/delete', 'UserController@deleteUser')->name('users.delete');
        Route::post('/{id}', 'UserController@updateUser')->name('users.update');
    });

    Route::group(['prefix' => 'depot'], function(){
        Route::get('/', 'DepotController@index')->name('depots.index');
        Route::post('/', 'DepotController@store')->name('depots.store');
        Route::post('/depots', 'DepotController@getDepots')->name('depots');
    });

    Route::group(['prefix' => 'color'], function(){
        Route::get('/', 'ColorController@index')->name('colors.index');
        Route::post('/', 'ColorController@store')->name('colors.store');
        Route::post('/colors', 'ColorController@getColors')->name('colors.getcolors');;
    });
});

// End Admin
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
