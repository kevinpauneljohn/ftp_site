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
    return redirect(route('login'));
});

Route::get('admin', function () {
    return view('admin_template');
});
Auth::routes([
    'register'  => false
]);

Route::get('/home', 'HomeController@index')->name('home');

/*Auth::routes();*/

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','role:super admin|admin|graphic artist']],function (){
    Route::get('/dashboard','DashboardController@dashboard');
    Route::get('/roles/roles','RolesController@roles');
    Route::post('/roles-create','RolesController@rolesForm')->name('roles');
    Route::post('/permission','PermissionController@permission')->name('permissions');

    Route::get('/product/add-product','ProductController@addProduct')->name('product.add');
    Route::get('/product/edit-product/{id}','ProductController@editProduct')->name('product.edit');
    Route::get('/product/products','ProductController@products')->name('products');
    Route::post('/product/create','ProductController@createProduct')->name('product.create');

    Route::get('/users','UserController@users')->name('users');
    Route::post('/user-create','UserController@userForm')->name('users.create');
});

Route::group(['middleware'  => ['role:customer']],function (){
    Route::get('/customer/dashboard','customer\CustomerController@dashboard')->name('customer.dashboard');
});
