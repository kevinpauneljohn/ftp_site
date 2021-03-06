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

use App\JobOrder;
use App\task;
use Spatie\Activitylog\Models\Activity;
use App\Events\FormSubmitted;

Route::get('admin', function () {
    return view('admin_template');
});
Auth::routes([
    'register'  => false
]);

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
    return redirect(route("login"));
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
    Route::get('/job-order/reference-number/{jobOrderId}','JobOrderController@referenceNumber')->name('job.order.reference.number');

    Route::get('/product/category','ProductController@category')->name('category')->middleware(['auth','role:admin|super admin']);
    Route::post('/add-category','ProductController@addCategory')->name('category.add')->middleware(['auth','role:admin|super admin']);
    Route::get('/category-data','ProductController@categoryData')->name('category.data')->middleware(['auth','role:admin|super admin']);
    Route::post('/category-edit-save','ProductController@editCategory')->name('category.save')->middleware(['auth','role:admin|super admin']);
    Route::post('/category-data-display','ProductController@displayCategoryData')->name('category.data.display')->middleware(['auth','role:admin|super admin']);
    Route::post('/delete-category','ProductController@deleteCategory')->name('category.delete')->middleware(['auth','role:admin|super admin']);
    Route::post('/set-status','TaskController@setSession')->name('task.status')->middleware(['auth']);
    Route::post('/job-set-status','JobOrderController@setSession')->name('job.order.status')->middleware(['auth']);

    Route::get('/job-order/edit/{jobOrderId}','JobOrderController@editJobOrderPage')->name('job.orders.edit')->middleware(['auth']);

    Route::post('/job-order/delete','JobOrderController@deleteJobOrder')->name('job.orders.delete')->middleware(['auth','role:super admin']);
    Route::post('/job-order-data','JobOrderController@displayJobOrderData')->name('job.orders.display.data')->middleware(['auth','role:super admin|admin']);
    Route::get('/job-order/tasks/{jobOrderId}','JobOrderController@jobOrderProfileTasks')->name('job.orders.tasks')->middleware(['auth']);
    Route::post('/job-order/status/complete','JobOrderController@markComplete')->name('job.order.status.complete')->middleware(['auth']);
    Route::get('/task/edit-page/{taskId}','TaskController@editTaskPage')->name('task.page.edit')->middleware(['auth']);
    Route::get('/job-order/print/{jobOrderId}','JobOrderController@print')->name('job.order.print')->middleware(['auth']);

    Route::post('/task-edit-save','TaskController@editSaveTask')->name('task.edit.save')->middleware(['auth']);
    Route::post('/task-get-data','TaskController@taskData')->name('task.data.display')->middleware(['auth','role:super admin']);
    Route::post('/task-delete-data','TaskController@deleteTask')->name('task.data.delete')->middleware(['auth','role:super admin']);
    Route::post('/user','UserController@userDetails')->name('user.data')->middleware(['auth']);

Route::get('/test',function (){
    $jobOrders = JobOrder::find(49)->tasks;
        $tasks = array();

        foreach ($jobOrders as $jobOrder){
            $tasks[$jobOrder->id] = $jobOrder->id;
        }

        $activities = Activity::where([
            ['subject_type','=','App\task'],
            ['subject_id','=',$tasks],
        ])->get();

        return $activities;
});

//Route::get('my-form','Testcontroller@myform');
//Route::post('my-form','Testcontroller@myformPost');
//
//Route::get('/counter', function (){
//    return view('counter');
//});
//
//Route::get('/sender', function (){
//    return view('sender');
//});
//
//Route::post('/sender', function (){
//
//    $text = request()->content;
//
//    event(new FormSubmitted($text));
//});

