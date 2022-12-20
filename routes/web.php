<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/home',
    ['uses' => 'HomeController@home', 'as' => 'home']
);

Route::get(
    '/admin/home',
    ['uses' => 'HomeController@home', 'as' => 'admin.home', 'middleware' => 'adminAuth']
);

//*====================================[Routes for Auth]====================================//

Route::group([
    'as' => "auth.",
    'namespace' => "Auth",


], function () {

    Route::get(
        'register',
        'RegisterController@register'
    );
    Route::post(
        'register',
        ['uses' => 'RegisterController@storeUser', 'as' => 'register']
    );

    Route::get(
        'login',
        ['uses' => 'LoginController@login', 'as' => 'login']
    );
    Route::post(
        'login',
        'LoginController@authenticate'
    );
    Route::get(
        'logout',
        ['uses' => 'LoginController@logout', 'as' => 'logout']
    );

    Route::get(
        'forget-password',
        'ForgotPasswordController@getEmail'
    );
    Route::post(
        'forget-password',
        'ForgotPasswordController@postEmail'
    );

    Route::get(
        'reset-password/{token}',
        'ResetPasswordController@getPassword'
    );

    Route::post(
        'reset-password',
        'ResetPasswordController@updatePassword'
    );

    Route::get(
        '/changePassword',
        ['uses' => 'ChangePasswordController@index', 'as' => 'changePassword']
    );
    Route::post(
        '/changePassword',
        ['uses' => 'ChangePasswordController@storeNewPassword', 'as' => 'storeNewPassword']
    );
});
//!====================================[End of Auth]====================================//



//*===================================[Routes for Contact]===================================//

Route::group([
    'as' => "contact.",
    // 'middleware' => "auth"
], function () {

    Route::get(
        '/contacts',
        ['uses' => 'ContactController@index', 'as' => 'index']
    );
    Route::get(
        '/contacts/create',
        ['uses' => 'ContactController@create', 'as' => 'create']
    );
    Route::get(
        '/contacts/{id}',
        ['uses' => 'ContactController@show', 'as' => 'show']
    );
    Route::get(
        '/contacts/edit/{id}',
        ['uses' => 'ContactController@edit', 'as' => 'edit']
    );
    Route::post(
        '/contacts/store',
        ['uses' => 'ContactController@store', 'as' => 'store']
    );
    Route::put(
        '/contacts/update/{id}',
        ['uses' => 'ContactController@update', 'as' => 'update']
    );
    Route::delete(
        '/contacts/delete/{id}',
        ['uses' => 'ContactController@destroy', 'as' => 'destroy']
    );
});
//!===================================[End of Contact]===================================//



//*====================================[Routes for Users]====================================//

Route::group([
    'as' => "user.",
    // 'middleware' => "auth"
], function () {

    Route::get(
        '/users',
        ['uses' => 'UsersController@index', 'as' => 'index']
    );

    Route::get(
        '/users/edit/{id}',
        ['uses' => 'UsersController@edit', 'as' => 'edit']
    );

    Route::post(
        '/users/store/',
        ['uses' => 'UsersController@store', 'as' => 'store']
    );

    Route::PUT(
        '/users/update/{id}',
        ['uses' => 'UsersController@update', 'as' => 'update']
    );

    Route::delete(
        '/users/{id}',
        ['uses' => 'UsersController@destroy', 'as' => 'destroy']
    );
});
//!====================================[End of Users]====================================//



//*====================================[Routes for Users]====================================//

Route::group([
    'as' => "customer.",
    // 'middleware' => "auth"
], function () {

    Route::get(
        '/customer',
        ['uses' => 'CustomerController@index', 'as' => 'index']
    );

    Route::get(
        '/customer/edit/{id}',
        ['uses' => 'CustomerController@edit', 'as' => 'edit']
    );

    Route::post(
        '/customer/store/',
        ['uses' => 'CustomerController@store', 'as' => 'store']
    );

    Route::PUT(
        '/customer/update/{id}',
        ['uses' => 'CustomerController@update', 'as' => 'update']
    );

    Route::delete(
        '/customer/{id}',
        ['uses' => 'CustomerController@destroy', 'as' => 'destroy']
    );
});





Route::group([
    'as' => "order.",
    // 'middleware' => "auth"
], function () {

    Route::get(
        '/order',
        ['uses' => 'OrderController@index', 'as' => 'index']
    );

    Route::get(
        '/customer/edit/{id}',
        ['uses' => 'OrderController@edit', 'as' => 'edit']
    );

    Route::post(
        '/customer/store/',
        ['uses' => 'OrderController@store', 'as' => 'store']
    );

    Route::PUT(
        '/customer/update/{id}',
        ['uses' => 'OrderController@update', 'as' => 'update']
    );

    Route::delete(
        '/customer/{id}',
        ['uses' => 'OrderController@destroy', 'as' => 'destroy']
    );
});
//!====================================[End of Users]====================================//
