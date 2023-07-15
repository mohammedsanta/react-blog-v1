<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[BlogController::Class,'index'])->name('index');



Route::group([
    'prefix' => 'auth',
    'as' => 'auth.'
],function () {

    Route::get('profile',[AuthController::class,'profile'])->name('profile');
    Route::post('profile/picture',[AuthController::class,'picture'])->name('picture');
    Route::post('profile/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::post('logout',[AuthController::class,'logout'])->name('logout');

    Route::group([
        'middleware' => 'guest',
    ],function () {

        Route::get('login',[AuthController::class,'index'])->name('loginView');
        Route::post('login',[AuthController::class,'login'])->name('login');
    
        Route::get('register',[AuthController::class,'create'])->name('register');
        Route::post('register',[AuthController::class,'store'])->name('store');

    });


});

Route::group([
    'middleware' => 'auth'
],function () {

    Route::get('yourposts',[BlogController::class,'yourPosts'])->name('yourPosts');
    
    Route::post('post/comment',[BlogController::class,'comment'])->name('comment');
    
});
Route::get('categories',[BlogController::class,'categories'])->name('categories');
Route::get('contact',[BlogController::class,'contact'])->name('contact');
Route::resource('post',BlogController::class);
