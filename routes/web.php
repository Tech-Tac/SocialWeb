<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/* Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome'); */

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', App\Http\Controllers\PostController::class)->only(["index", "show"]);
Route::resource('posts', App\Http\Controllers\PostController::class)->except(["index", "show"])->middleware("auth");
Route::get('posts/{post}/view', [App\Http\Controllers\PostController::class, "view"])->name('posts.view');
Route::post('posts/{post}/like', [App\Http\Controllers\PostController::class, "like"])->name('posts.like')->middleware("auth");

Route::resource('comments', App\Http\Controllers\CommentController::class)->except(["index", "create"])->middleware("auth");
Route::post('comments/{comment}/like', [App\Http\Controllers\CommentController::class, "like"])->name('comments.like')->middleware("auth");

Route::get('users/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit')->middleware("auth");
Route::put('users/edit', [App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware("auth");
Route::delete('users/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy')->middleware("auth");
Route::resource('users', App\Http\Controllers\UserController::class)->only(["index", "show"]);

Route::post('users/{user}/add_friend', [App\Http\Controllers\UserController::class, "addFriend"])->name('users.add_friend')->middleware("auth");

Route::resource('groups', App\Http\Controllers\GroupController::class)->except(["index", "show"])->middleware("auth");
Route::resource('groups', App\Http\Controllers\GroupController::class)->only(["index", "show"]);
Route::post('groups/{group}/join', [App\Http\Controllers\GroupController::class, "join"])->name('groups.join')->middleware("auth");
Route::post('groups/{group}/leave', [App\Http\Controllers\GroupController::class, "leave"])->name('groups.leave')->middleware("auth");

Route::get("search", [App\Http\Controllers\SearchController::class, "index"])->name("search");
