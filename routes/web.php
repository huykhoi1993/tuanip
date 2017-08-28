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

// Admin
// Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        // return view('test');
        return redirect('/admin');
    });

    Route::get('users/{id}', function() {
        //
    });

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
            Route::get('/storagesproduct', 'ProductController@getStoragesProduct')->name('storagesproduct');
            Route::get('/qualitiesproduct', 'ProductController@getQualitiesProduct')->name('qualitiesproduct');
            Route::get('/colorsproduct', 'ProductController@getColorsProduct')->name('colorsproduct');
            Route::get('/versionsproduct', 'ProductController@getVersionsProduct')->name('versionsproduct');
            Route::post('/{id}/delete', 'ProductController@deleteProduct')->name('products.delete');
            Route::post('/{id}', 'ProductController@updateProduct')->name('products.update');
        });

        Route::group(['prefix' => 'member'], function(){
            Route::get('/', 'MemberController@index')->name('members.index');
            Route::post('/', 'MemberController@store')->name('members.store');
            Route::post('/members', 'MemberController@getMembers')->name('members');
            Route::get('/membersname', 'MemberController@getMembersName')->name('membersname');
            Route::post('/delete', 'MemberController@deleteMember')->name('members.delete');
            Route::post('/update', 'MemberController@updateMember')->name('members.update');
        });

        Route::group(['prefix' => 'depot'], function(){
            Route::get('/', 'DepotController@index')->name('depots.index');
            Route::post('/', 'DepotController@store')->name('depots.store');
            Route::post('/depots', 'DepotController@getDepots')->name('depots');
        });

        Route::group(['prefix' => 'color'], function(){
            Route::get('/', 'ColorController@index')->name('colors.index');
            Route::post('/', 'ColorController@store')->name('colors.store');
            Route::post('/colors', 'ColorController@getColors')->name('colors.getcolors');
        });

        Route::group(['prefix' => 'statistic'], function(){
            Route::get('/products', 'StatisticController@products')->name('statistic.products');
            Route::get('/', 'StatisticController@index')->name('statistic.index');
            Route::get('/getallproducts', 'StatisticController@getAllProducts')->name('statistic.getallproducts');
            Route::get('/gettotalmoneyimport', 'StatisticController@getTotalMoneyImport')->name('statistic.gettotalmoneyimport');
            Route::get('/gettotalmoneyexport', 'StatisticController@getTotalMoneyExport')->name('statistic.gettotalmoneyexport');
        });

        Route::group(['prefix' => 'debit'], function(){
            Route::get('/', 'DebitController@index')->name('debits.index');
            Route::post('/', 'DebitController@store')->name('debits.store');
            Route::post('/debits', 'DebitController@getDebits')->name('debits');
        });
    });

    Route::get('/home', 'HomeController@index')->name('home');
// });
// End Admin
Auth::routes();
