<?php

// use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@welcome')->name('index');
Route::get('language/{locale}', 'LocalizationController@index');
Route::get('/byShop/{byshop}/service', 'HomeController@byShop');
// Route::get('/byService/{byservice:menu_id}/service', 'WelcomeController@byService');
Route::post('/byShop/tokenReg', 'HomeController@tokenReg');
Route::post('/byShop/tokenCancel', 'HomeController@tokenCancel');

Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register.submit');
Route::get('/verify_email/{id}/{key}','Auth\RegisterController@verify_email');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/queue', 'QueueController@index')->name('admin.shop');
    Route::post('/queue/callNext', 'QueueController@callNext');
    Route::post('/queue/callAgain', 'QueueController@callAgain');
    // Login routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    // Logout route
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    // Register routes
    Route::get('/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');
    Route::get('/verify_email/{id}/{key}','Auth\AdminRegisterController@verify_email');

    // Password reset routes
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');

    // shop
    Route::get('/shop', 'ShopController@index')->name('admin.shop');
    Route::get('/shop/create', 'ShopController@create');
    Route::post('/shop/create', 'ShopController@store')->name('admin.shop.create.submit');
    // Route::get('/shop/edit/{id}', 'ShopController@edit')->name('admin.shop.edit');
    Route::get('/shop/{shop}/edit', 'ShopController@edit');
    // Route::post('/shop/update', 'ShopController@update')->name('admin.shop.update.submit');
    Route::patch('/shop/{shop}/update', 'ShopController@update')->name('admin.shop.update');
    Route::post('/shop/mkinvalid', 'ShopController@mkValidInvalid')->name('admin.shop.mkinvalid.submit');

    // service
    Route::get('/service', 'ServiceController@index')->name('admin.service');
    Route::get('/service/create', 'ServiceController@create');
    Route::post('/service/create', 'ServiceController@store')->name('admin.service.create.submit');
    Route::get('/service/{service}/edit', 'ServiceController@edit');
    Route::patch('/service/{service}/update', 'ServiceController@update')->name('admin.service.update');
    Route::post('/service/mkinvalid', 'ServiceController@mkValidInvalid')->name('admin.service.mkinvalid.submit');

    // barber
    Route::get('/barber', 'BarberController@index')->name('admin.barber');
    Route::get('/barber/create', 'BarberController@create');
    Route::post('/barber/create', 'BarberController@store')->name('admin.barber.create.submit');
    Route::get('/barber/{barber}/edit', 'BarberController@edit');
    Route::patch('/barber/{barber}/update', 'BarberController@update')->name('admin.barber.update');
    Route::post('/barber/mkinvalid', 'BarberController@mkValidInvalid')->name('admin.barber.mkinvalid.submit');

});

Route::get('/clear', function() {

   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');

   return "Cleared!";

});