<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', function(){
    return view('home');
});


Route::get('/projects/users', [HomeController::class, 'projects_users'])->name('projects_users');

Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::get('/logs', [HomeController::class, 'logs'])->name('logs');

// Route::get('/users/create', [UserController::class, 'create'])->name('users.create_user');