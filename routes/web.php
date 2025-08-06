<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'admin.',
        'prefix' => 'admin/',
        'middleware' => 'auth'
    ],
    function () {
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    }
);

Route::resource('categories', \App\Http\Controllers\CategoryController::class, ['except' => ['update', 'show', 'destroy', 'store']]);

Route::group([
    'as' => 'api.',
    'prefix' => 'api/',
    // 'middleware' => 'auth'
], function () {
    Route::group([
        'as' => 'categories.',
        'prefix' => 'categories/'
    ], function () {
        Route::get('data-user', [\App\Http\Controllers\Api\CategoryController::class, 'dataTableUser']);
    });
    Route::resource('categories', \App\Http\Controllers\Api\CategoryController::class, ['except' => ['show', 'index', 'edit', 'create']]);
});