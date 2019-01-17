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

Route::get('/', 'TopicsController@index')->name('root');

// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::post('users/{user}/qrcode', 'UsersController@downloadQrcode')->name('users.qrcode');
Route::get('users/{user}/barcode', 'UsersController@barcode')->name('users.barcode');

// package Maatwebsite/Laravel-Excel
Route::get('topics/excel', 'TopicsController@excel')->name('topics.excel');
Route::post('topics/export', 'TopicsController@export')->name('topics.export');
Route::post('topics/import', 'TopicsController@import')->name('topics.import');

Route::get('topics/{topic}/pdf', 'TopicsController@pdf')->name('topics.pdf')->middleware('cacheResponse:60');

Route::get('topics/{topic}/image', 'TopicsController@image')->name('topics.image');
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'update', 'destroy']]);


Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

// rap2hpoutre/laravel-log-viewer 日志查看路由
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// package chumper/zipper
Route::get('zip', 'ZipController@index')->name('zip.index');
Route::post('zip/download', 'ZipController@download')->name('zip.download');
Route::post('zip/upload', 'ZipController@upload')->name('zip.upload');

// package roumen/sitemap
Route::get('sitemap', 'SitemapController@index')->name('sitemap.index');
Route::get('sitemap/topics', 'SitemapController@topics')->name('sitemap.topics.index');
Route::get('sitemap/users', 'SitemapController@users')->name('sitemap.users.index');

// package lubusin/laravel-decomposer
Route::get('decompose','\Lubusin\Decomposer\Controllers\DecomposerController@index');