<?php

use App\Http\Controllers\{DepartmentController, EmployeeController, PositionController, ProjectController, SupportTicketController, TaskController, UserController};
use Illuminate\Support\Facades\Route;

Route::post('sign-in',[UserController::class,'signIn']);

$routes = [
    ['controller' => DepartmentController::class,'prefix' => 'departments'],
    ['controller' => PositionController::class,'prefix' => 'positions'],
    ['controller' => EmployeeController::class,'prefix' => 'employees'],
    ['controller' => ProjectController::class,'prefix' => 'projects'],
    ['controller' => SupportTicketController::class,'prefix' => 'support-tickets'],
    ['controller' => TaskController::class,'prefix' => 'tasks'],
];
Route::middleware('auth:api')->group(function() use ($routes){
    foreach($routes as $route){
        Route::controller($route['controller'])->prefix($route['prefix'])->group(function(){
            Route::get('show','show');
            Route::get('show-by-id/{id}','showById');
            Route::post('store','store');
            Route::put('update/{id}','update');
            Route::delete('delete/{id}','delete');
        });
    }

    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('who-am-i','whoAmI');
        Route::get('show','show');
        Route::get('show-by-id/{user}','showById');
        Route::post('store','store');
        Route::put('update/{user}','update');
        Route::delete('delete/{user}','delete');
    });
});
