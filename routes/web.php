<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/createpost', function () {
    return view('createpost');
})->middleware('adminAuth');

Route::get('/signin', function () {
    return view('signin');
});

Route::post('/deletepost/{id}', [PostController::class, 'destroy'])->middleware('adminAuth');
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/myposts', [PostController::class, 'myposts'])->middleware('adminAuth');
Route::post('/createpost', [PostController::class, 'store'])->middleware('adminAuth');
Route::post('/signin', [AuthController::class, 'signIn']);
Route::get('/signout', [AuthController::class, 'signOut']);