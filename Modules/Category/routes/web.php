<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'admin.',
        'prefix' => 'admin/',
        // 'middleware' => 'auth'
    ],
    function () {
        Route::resource('categories', \Modules\Category\Http\Controllers\Admin\CategoryController::class, ['except' => ['update', 'show', 'destroy', 'store']]);
    }
);

Route::resource('categories', \Modules\Category\Http\Controllers\CategoryController::class, ['except' => ['update', 'show', 'destroy', 'store']]);

Route::group([
    'as' => 'api.',
    'prefix' => 'api/',
    // 'middleware' => 'auth'
], function () {
    Route::group([
        'as' => 'categories.',
        'prefix' => 'categories/'
    ], function () {
        Route::get('data', [\Modules\Category\Http\Controllers\Api\CategoryController::class, 'dataTable']);
        Route::get('data-user', [\Modules\Category\Http\Controllers\Api\CategoryController::class, 'dataTableUser']);
    });
    Route::resource('categories', \Modules\Category\Http\Controllers\Api\CategoryController::class, ['except' => ['show', 'index', 'edit', 'create']]);
});
