<?php

use App\Http\Controllers\FormTestController;
use App\Models\User;
use App\Models\jalan;
use App\Models\pelanggaran;

use App\Http\Resources\JalanResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ViolationResource;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\UserController;

use App\Http\Requests\StorejalanRequest;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\mainAlgoController;
use App\Http\Controllers\PerjalananController;

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


Route::resource('/perjalanan', PerjalananController::class);
Route::resource('/user', UserController::class);
Route::resource('/jalan', JalanController::class);

Route::get('/', function () {return view('home');});
Route::get('/user/{id_user}', function ($id) {return new UserResource(User::findOrFail($id));});
Route::get('/users', function () {return UserResource::collection(User::all());});
Route::get('/jalans', function () {return JalanResource::collection(jalan::all());});
Route::get('/map',[MapsController::class,'index']);
Route::get('/violation', function () {return ViolationResource::collection(pelanggaran::all());});
Route::get('/register',function(){return view('register');});
Route::get('/blogs',function(){return view('blogs.home_blog');});
Route::get('/test',function(StorejalanRequest $request){
    dd($request);
});
Route::get('/form',[FormTestController::class,'index']);


// POST
Route::post('/map',[MapsController::class,'maps']);
Route::post('/mainalgo',[mainAlgoController::class,'index']);
Route::post('/form',[FormTestController::class,'tampilGet']);

// PUT
Route::put('/map',[MapsController::class,'updateMaps']);

