<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\ProjectController;

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

//AUTH ROUTES
Auth::routes();

//HOME (index)
Route::get('/', [HomeController::class, 'index'])->name('home');

//Only admin can visit this routes
Route::middleware(['admin.role'])->group(function () {

        //User registration that can be accessable only to admin
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/register', function () {
                return redirect()->route('users.create');
        });

        //Store User
        Route::post('/users/create/store', [UserController::class, 'store'])->name('users.store');

        //List of all the users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        //Edit user
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

        //Update user
        Route::put('/users/{id}/update', [UserController::class, 'update'])->name('users.update');

        //List of all available projects - here is the option to assign/unassign user from a project
        Route::get('/users/{id}/projects/', [UserController::class, 'usersProjects'])->name('users.projects');

        //Assign-Unassign user from project - POST/DELETE
        Route::post('/users/{user_id}/projects/{project_id}/assign', [UserController::class, 'usersProjectsAssign'])
                ->name('users.projects.assign');

        Route::delete('/users/{user_id}/projects/{project_id}/unassign', [UserController::class, 'usersProjectsUnassign'])
                ->name('users.projects.unassign');


        //List of all the projects
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

        //Create project
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');

        //Store project
        Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');


        //List of all the logs
        Route::get('/logs', [LogController::class, 'index'])->name('log.index');


        //List of all the logs
        Route::get('/logs', [LogController::class, 'index'])->name('log.index');


        //API CONFIG
        //List of all API Keys for selected user for certain project
        Route::get('/projects/{project_id}/users/{user_id}/api-keys', [ApiKeyController::class, 'indexApiByAdmin'])
                ->name('projects.users.apiKeys.index');

        //Store API Key for selected user for certain project
        Route::post('/projects/{project_id}/users/{user_id}/api-keys', [ApiKeyController::class, 'storeApiByAdmin'])
                ->name('projects.users.apiKeys.store');

        //Delete API Key for selected user for certain project (SOFTDELETE)
        Route::delete('/projects/{project_id}/users/{user_id}/api-keys/{api_key_id}/delete', 
                [ApiKeyController::class, 'destroyApiByAdmin'])
                ->name('projects.users.apiKeys.destroy');

});

//Project Statistics
Route::get('/projects/{id}/', [ProjectController::class, 'show'])->name('projects.show');

//Users Projects and Logs - self explanatory
Route::get('/my-projects', [ProjectController::class, 'myProjects'])->name('projects.myprojects');

Route::get('/my-logs', [LogController::class, 'show'])->name('log.mylogs');


//Create a Log Page
Route::get('/log/project/{id}', [LogController::class, 'create'])->name('log.create');

Route::post('/log/project/{id}/store', [LogController::class, 'store'])->name('log.store');



//API CONFIG
//List of all API Keys for auth user for certain project
Route::get('/projects/{project_id}/api-keys', [ApiKeyController::class, 'index'])
        ->name('projects.apiKeys.index');

//Create API Key for auth user for certain project
Route::post('/projects/{project_id}/api-keys/store', [ApiKeyController::class, 'store'])
        ->name('projects.apiKeys.store');

//Delete API Key for auth user for certain project (SOFTDELETE)
Route::delete('/projects/{project_id}/api-keys/{api_key_id}/delete', [ApiKeyController::class, 'destroy'])
        ->name('projects.apiKeys.destroy');
