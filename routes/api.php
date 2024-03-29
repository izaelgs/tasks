<?php

use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function() {
    return 'Bem Vindo à Api IzaTasks';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers\Api')->group(function() {
    Route::middleware('auth:sanctum')->group( function() {
        Route::resource('category', 'CategoryController');

        Route::resource('project', 'ProjectController');
        Route::get('project/{id}/lists', [ProjectController::class, 'lists'])->name('project.lists');

        Route::resource('list', 'ProjectListController');


        Route::resource('item', 'ItemController');
    });
});

Route::post('/tokens/create', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});
