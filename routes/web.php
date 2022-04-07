<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\MessageController::class, 'chatindex']);

Route::get('/profile', [App\Http\Controllers\MessageController::class, 'profile']);
Route::post('/save-profile', [App\Http\Controllers\ProfileController::class, 'saveprofile']);
Route::get('/getuserprofile', [App\Http\Controllers\ProfileController::class, 'getuser']);
Route::get('/otherprofile/{id}', [App\Http\Controllers\ProfileController::class, 'otherprofile']);
Route::get('/getotherprofile/{id}', [App\Http\Controllers\ProfileController::class, 'getotherprofile']);
Route::get('/logout', [App\Http\Controllers\MessageController::class, 'logout']);
Route::post('/accept-request/{id}', [App\Http\Controllers\MessageController::class, 'accept']);
Route::delete('/remove-request/{id}', [App\Http\Controllers\MessageController::class, 'remove']);
Route::delete('/delete-friend/{id}', [App\Http\Controllers\MessageController::class, 'deletefriend']);
Route::get('/getallnotify',  [App\Http\Controllers\MessageController::class, 'getnotify']);
Route::get('/search',  [App\Http\Controllers\MessageController::class, 'search']);
Route::delete('delete-message/{id}', [App\Http\Controllers\MessageController::class, 'deletemessage']);
Route::get('/users',[App\Http\Controllers\MessageController::class, 'users']);
Route::get('/currentuser',[App\Http\Controllers\MessageController::class, 'currentuser']);
Route::get('/private-message/{user}',[App\Http\Controllers\MessageController::class, 'privatemessage']);
Route::post('/private-message/{user}',[App\Http\Controllers\MessageController::class, 'sendprivatemessage']);
Route::post('/sendfriendrequest',[App\Http\Controllers\MessageController::class, 'friendrequest']);
Route::get('/messages', [App\Http\Controllers\MessageController::class, 'getmessage']);
Route::post('/messages', [App\Http\Controllers\MessageController::class, 'sendmessage']);
Route::post('/activeuser', [App\Http\Controllers\MessageController::class, 'activeuser']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
