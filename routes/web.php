<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminLoginContoller;
use App\Http\Controllers\Admin\HomeContoller;
use App\Http\Controllers\Manager\ManagerLoginContoller;
use App\Http\Controllers\Manager\ManagerHomeContoller;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['prefix' => 'admin'], function() {

    Route::group(['middleware' => 'admin.guest'], function() {
        Route::get('/login',[AdminLoginContoller::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginContoller::class,'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function() {
        Route::get('/dashboard',[HomeContoller::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeContoller::class,'logout'])->name('admin.logout');
    });

});

Route::group(['prefix' => 'manager'], function() {

    Route::group(['middleware' => 'manager.guest'], function() {
        Route::get('/login',[ManagerLoginContoller::class, 'index'])->name('manager.login');
        Route::post('/authenticate',[ManagerLoginContoller::class,'authenticate'])->name('manager.authenticate');
    });

    Route::group(['middleware' => 'manager.auth'], function() {
        Route::get('/dashboard',[ManagerHomeContoller::class,'index'])->name('manager.dashboard');
        Route::get('/logout',[ManagerHomeContoller::class,'logout'])->name('manager.logout');
    });

});
