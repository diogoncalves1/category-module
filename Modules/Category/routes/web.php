<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'admin.',
        'prefix' => 'admin/',
        'middleware' => 'auth'
    ],
    function () {
        Route::resource('categories', \Modules\Category\Http\Controllers\Admin\CategoryController::class, ['except' => ['update', 'show', 'destroy', 'store']]);
    }
);

Route::resource('categories', \Modules\Category\Http\Controllers\CategoryController::class, ['except' => ['update', 'show', 'destroy', 'store']]);
