<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::apiResource('/employees','Api\EmployeeController');

Route::apiResource('/suppliers','Api\SupplierController');
Route::apiResource('/category','Api\CategoryController');
Route::apiResource('/product','Api\ProductController');
Route::apiResource('/customer','Api\CustomerController');

Route::Get('getting/product/{id}', 'Api\PosController@GetProduct');

Route::get('addToCart/{id}', 'Api\CartController@AddToCart');

Route::get('allcartitems', 'Api\CartController@allcartitems');

Route::get('removecartitem/{id}', 'Api\CartController@removecartitem');

Route::get('increment/{id}', 'Api\CartController@increment');

Route::get('decrement/{id}', 'Api\CartController@decrement');

Route::get('vats/', 'Api\CartController@Vats');

Route::post('orderdone/', 'Api\PosController@OrderDone');

Route::get('orders/', 'Api\PosController@Order');

Route::post('search/order', 'Api\PosController@SearchOrderDate');


//Admin

Route::get('today/sale', 'Api\PosController@todaySale');

Route::get('today/income', 'Api\PosController@todayIncome');

Route::get('today/due', 'Api\PosController@todayDue');

Route::get('today/product', 'Api\PosController@todayProduct');

Route::get('today/stockproduct', 'Api\PosController@stockProduct');