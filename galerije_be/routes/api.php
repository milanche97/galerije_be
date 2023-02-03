<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::get('me', 'AuthController@getActiveUser');


    Route::get('galleries', 'GalleriesController@index');
    Route::get('galleries/{id}', 'GalleriesController@show');
    Route::post('galleries', 'GalleriesController@store');
    Route::put('galleries/{id}', 'GalleriesController@update');
    Route::delete('galleries/{id}', 'GalleriesController@destroy');

    // Route::delete('galleries', 'GalleryController@destroy');

    // Route::resource('galleries', GalleryController::class);

    Route::get('/galleries/{id}/comments', [CommentsController::class, 'index']);
    Route::get('/comments/{id}', [CommentsController::class, 'show']);
    Route::post('/galleries/{id}/comments', [CommentsController::class, 'store']);
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
});
