<?php

use App\Http\Controllers\{CompanyController, DepartmentController, EmployeeController, PositionController, ProjectController, SupportTicketController, TaskController, UserController};
use Illuminate\Support\Facades\Route;

Route::post('sign-in',[UserController::class,'signIn']);

Route::middleware('auth:api')->group(function(){
    Route::controller(DepartmentController::class)->prefix('departments')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{department}','showById');
        Route::post('create','create');
        Route::put('update/{department}','update');
        Route::delete('delete/{department}','delete');
    });
    
    Route::controller(PositionController::class)->prefix('positions')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{position}','showById');
        Route::post('create','create');
        Route::put('update/{position}','update');
        Route::delete('delete/{position}','delete');
    });
    
    Route::controller(EmployeeController::class)->prefix('employees')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{employee}','showById');
        Route::post('create','create');
        Route::put('update/{employee}','update');
        Route::delete('delete/{employee}','delete');
    });

    Route::controller(ProjectController::class)->prefix('projects')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{project}','showById');
        Route::post('create','create');
        Route::put('update/{project}','update');
        Route::delete('delete/{project}','delete');
    });

    Route::controller(SupportTicketController::class)->prefix('support-tickets')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{supportTicket}','showById');
        Route::post('create','create');
        Route::put('update/{supportTicket}','update');
        Route::delete('delete/{supportTicket}','delete');
    });

    Route::controller(TaskController::class)->prefix('tasks')->group(function(){
        Route::get('show-all','showAll');
        Route::get('show-by-id/{task}','showById');
        Route::post('create','create');
        Route::put('update/{task}','update');
        Route::delete('delete/{task}','delete');
    });

    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('who-am-i','whoAmI');
        Route::get('show-all','showAll');
        Route::get('show-by-id/{user}','showById');
        Route::post('create','create');
        Route::put('update/{user}','update');
        Route::delete('delete/{user}','delete');
    });
});
