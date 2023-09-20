<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LogController;

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


//USER STUFF
Route::middleware(['admin.role'])->group(function(){
    Route::get('/register', function(){
        return view('auth.register');
    })->name('register');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/{id}/projects/', [UserController::class, 'users_projects'])->name('users.projects');

    Route::post('/users/{user_id}/projects/{project_id}/assign', [UserController::class, 'users_projects_assign'])->name('users.projects.assign');

    Route::delete('/users/{user_id}/projects/{project_id}/unassign', [UserController::class, 'users_projects_unassign'])->name('users.projects.unassign');

});