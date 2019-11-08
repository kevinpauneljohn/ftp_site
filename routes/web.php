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

//Route::get('/', function () {
//    return redirect(route('login'));
//});

Route::get('admin', function () {
    return view('admin_template');
});
Auth::routes([
    'register'  => false
]);

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
    return redirect(route("customer.index"));
})->name('home');

/*Auth::routes();*/

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','role:super admin|admin|graphic artist|sales']],function (){
    Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');
    Route::get('/roles/roles','RolesController@roles');
    Route::post('/roles-create','RolesController@rolesForm')->name('roles');
    Route::post('/permission','PermissionController@permission')->name('permissions');

    Route::post('/create-job-order','JobOrderController@createJobOrder')->name('job.orders.create');

    Route::get('/users','UserController@users')->name('users');
    Route::post('/user-create','UserController@userForm')->name('users.create');

    Route::get('/job-order/orders','JobOrderController@jobOrderPage')->name('job.orders');
    Route::get('/job-order/data','JobOrderController@jobOrdersData')->name('job.orders.datatables');
    Route::get('/job-order/profile/{jobOrderId}','JobOrderController@jobOrderProfile')->name('job.order.profile');
    Route::get('/task/profile/{taskId}','TaskController@taskProfile')->name('task.profile');
});

Route::group(['middleware' => ['auth','permission:view job orders']], function (){
    Route::get('/job-order/add-job-order','JobOrderController@addJobOrderPage')->name('job.orders.add');
});

Route::group(['middleware' => ['auth','role:super admin|admin']], function (){

    Route::get('/product/add-product','ProductController@addProduct')->name('product.add');
    Route::get('/product/edit-product/{id}','ProductController@editProduct')->name('product.edit');
    Route::get('/product/products','ProductController@products')->name('products');
    Route::post('/product/create','ProductController@createProduct')->name('product.create');
    Route::post('/product/update','ProductController@updateProduct')->name('product.update');
});

    Route::get('/','customer\CustomerController@index')->name('customer.index');
    Route::get('/category/{category}','customer\CustomerController@singleCategory')->name('customer.single');
    Route::post('/product-detail','ProductController@singleProductDetail')->name('product.detail');
    Route::get('/category/{category}/product/{id}','customer\CustomerController@singleProductDetails')->name('product.show');
    Route::post('/save-orders','OrdersController@saveOrders')->name('orders.save');
    Route::post('/add-to-cart','OrdersController@addToCart')->name('orders.cart');
    Route::get('/cart','customer\CustomerController@getCart')->name('cart');
    Route::get('/remove-item/{rowId}','OrdersController@removeItemFromCart')->name('cart.remove');
    Route::post('/update-cart','OrdersController@updateCart')->name('cart.update');
    Route::post('/ajax-login','Auth\AjaxLoginController@authenticate')->name('ajax.login');
    Route::get('/task/my-task','TaskController@taskPage')->name('task.mine');
    Route::get('/task/all-task','TaskController@allTasks')->name('task.all');
    Route::get('/user-task','TaskController@userTask')->name('task.list');
    Route::get('/all-task-data','TaskController@allTaskData')->name('task.all.list');
    Route::post('/status-action','TaskController@statusAction')->name('task.status.action');
    Route::post('/create-task','TaskController@createTask')->name('task.create');


Route::get('/test',function (){
    return view('layouts.customer_template');
});
