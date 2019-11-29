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

use App\Http\Middleware\LoginAdmin;

Route::get('/', function () {
    return view('user_welcome');
});

//Auth::routes();
Route::prefix('auth')->group(function () {
    Route::prefix('user')->group(function () {
        route::get('login', 'Auth\LoginController@showLoginForm')->name('user.login');
        route::post('login', 'Auth\LoginController@login');
        route::post('logout', 'Auth\LoginController@logout')->name('user.logout');

        route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        route::post('register', 'Auth\RegisterController@register');

        route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    });

    Route::prefix('admin')->group(function () {
        route::get('login', 'AdminLoginController@showLoginForm')->name('admin.login');
        route::post('login', 'AdminLoginController@login');
        route::post('logout', 'AdminLoginController@logout')->name('admin.logout');

        route::get('register', 'AdminRegisterController@showRegistrationForm')->name('admin.register');
        route::post('register', 'AdminRegisterController@register');

        route::get('password/reset', 'AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        route::post('password/email', 'AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        route::get('password/reset/{token}', 'AdminResetPasswordController@showResetForm')->name('admin.password.reset');
        route::post('password/reset', 'AdminResetPasswordController@reset')->name('admin.password.update');
    });
});

Route::prefix('admin')->middleware('LoginAdmin')->group(function () {
    Route::get('/', function () {
        return view('admins.dashboard.statistical');
    });
    Route::resources(['categories' => 'Admins\CategoryController']);
});

Route::prefix('user')->group(function () {
    Route::get('home', 'UserHomeController@index')->name('user.home');
});




