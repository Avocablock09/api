<?php

use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;

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
    return view('home');
});

Route::resource('perjalanan', PerjalananController::class);

Route::get('/user/{id_user}', function ($id) {
    return new UserResource(User::findOrFail($id));
});
 
Route::get('/users', function () {
    return UserResource::collection(User::all());
});
