<?php

use App\Http\Controllers\{DepartmentController,ProjectController, TaskController, UserController};
use App\Http\Middleware\PasswordExpired;
use Illuminate\Support\Facades\Route;
Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::post('sign-in','signIn');
    Route::post('forgot-password','forgotPassword');
    Route::middleware(['auth:api'])->group(function(){
        Route::get('profile','profile');
        Route::get('sign-out','signOut');
        Route::put('change-password','changePassword');
    });
});

Route::middleware(['auth:api', PasswordExpired::class])->group(function(){
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('show','show')->can('check-user');
        Route::get('show-by-id/{id}','showById')->can('check-user');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::post('store','store')->can('check-user');
        Route::put('update/{id}','update')->can('check-user');
        Route::delete('delete/{id}','delete')->can('check-user');
    });

    Route::controller(DepartmentController::class)->middleware(['can:is_admin'])->prefix('departments')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(ProjectController::class)->prefix('projects')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(TaskController::class)->prefix('tasks')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
        //Comments
        Route::get('comments/show/{id}','comments');
        Route::post('comments/store-comment','storeComment');
    });
});