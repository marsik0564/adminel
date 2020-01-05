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

Route::get('/home', 'HomeController@index')->name('home');

// Admin side

Route::group(['middleware' => ['status', 'auth']], function() {
    
    $groupData = [
        'namespace' => 'Blog\Admin',
        'prefix'    => 'admin',
    ];
    
    Route::group($groupData, function() {
        Route::resource('index', 'MainController')
            ->names('blog.admin.index');
            
        Route::resource('orders', 'OrderController')
            ->names('blog.admin.orders');     
        Route::get('/orders/change/{id}', 'OrderController@change')
            ->name('blog.admin.orders.change');        
        Route::post('/orders/save/{id}', 'OrderController@save')
            ->name('blog.admin.orders.save');           
        Route::get('/orders/forcedestroy/{id}', 'OrderController@forceDestroy')
            ->name('blog.admin.orders.forcedestroy'); 
        
        Route::get('/categories/mydel','CategoryController@mydel')
            ->name('blog.admin.categories.mydel');
        Route::resource('categories', 'CategoryController')
            ->names('blog.admin.categories');
            
        Route::resource('users', 'UserController')
            ->names('blog.admin.users');
            
            
        Route::get('/products/related','ProductController@related');  
        Route::match(['get', 'post'], '/products/ajax-image-upload', 'ProductController@ajaxImageUpload');
        Route::delete('/products/ajax-image-remove/{filename}', 'ProductController@ajaxImageRemove');
        Route::post('/products/gallery', 'ProductController@ajaxGalleryUpload')
            ->name('blog.admin.products.gallery');
        Route::post('/products/delete-gallery', 'ProductController@ajaxGalleryDelete')
            ->name('blog.admin.products.deletegallery');
        Route::get('/products/return-status/{id}', 'ProductController@returnStatus')
            ->name('blog.admin.products.returnstatus');
        Route::get('/products/delete-status/{id}', 'ProductController@deleteStatus')
            ->name('blog.admin.products.deletestatus');
        Route::get('/products/delete-product/{id}', 'ProductController@deleteProduct')
            ->name('blog.admin.products.deleteproduct');
               
        Route::resource('products', 'ProductController')
            ->names('blog.admin.products');
            
        Route::get('/filter/group-filter', 'FilterController@groupFilter');
        Route::match(['get', 'post'], '/filter/group-filter-add', 'FilterController@groupFilterAdd');
        Route::match(['get', 'post'], '/filter/group-filter-edit/{id}', 'FilterController@groupFilterEdit');
        Route::get('/filter/group-filter-delete/{id}', 'FilterController@groupFilterDelete');
        
        Route::get('/filter/value-filter', 'FilterController@valueFilter');
        Route::match(['get', 'post'], '/filter/value-filter-add', 'FilterController@valueFilterAdd');
        Route::match(['get', 'post'], '/filter/value-filter-edit/{id}', 'FilterController@valueFilterEdit');
        Route::get('/filter/value-filter-delete/{id}', 'FilterController@valueFilterDelete');
               
        Route::get('/currencies/delete-currency/{id}', 'CurrencyController@delete')
            ->name('blog.admin.currencies.delete-currency');
        Route::resource('currencies', 'CurrencyController')
            ->names('blog.admin.currencies');
            
        Route::get('/search/result', 'SearchController@index');
        Route::get('/autocomplete', 'SearchController@search');
    });
});

Route::get('user/index', 'Blog\User\MainController@index');