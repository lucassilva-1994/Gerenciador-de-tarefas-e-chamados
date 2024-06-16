<?php

use App\Http\Controllers\{DepartmentController, EmployeeController, PermissionController, PermissionRoleController, PositionController, ProjectController, RoleController, SupportTicketController, TaskController, UserController};
use App\Models\Position;
use Illuminate\Support\Facades\Route;

Route::post('sign-in',[UserController::class,'signIn']);
Route::middleware('auth:api')->group(function() {

    Route::controller(DepartmentController::class)->prefix('departments')->group(function() {
        Route::get('show', 'show')->can('show_departments');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_department');
        Route::put('update/{id}', 'update')->can('update_department');
        Route::delete('delete/{id}', 'delete')->can('delete_department');
    });
    
    Route::controller(EmployeeController::class)->prefix('employees')->group(function() {
        Route::get('show', 'show')->can('show_employees');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_employee');
        Route::put('update/{id}', 'update')->can('update_employee');
        Route::delete('delete/{id}', 'delete')->can('delete_employee');
    });
    
    Route::controller(PositionController::class)->prefix('positions')->group(function() {
        Route::get('show', 'show')->can('show_positions');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_position');
        Route::put('update/{id}', 'update')->can('update_position');
        Route::delete('delete/{id}', 'delete')->can('delete_position');
    });
    
    Route::controller(ProjectController::class)->prefix('projects')->group(function() {
        Route::get('show', 'show')->can('show_projects');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_project');
        Route::put('update/{id}', 'update')->can('update_project');
        Route::delete('delete/{id}', 'delete')->can('delete_project');
    });
    
    Route::controller(TaskController::class)->prefix('tasks')->group(function() {
        Route::get('show', 'show')->can('show_tasks');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_task');
        Route::put('update/{id}', 'update')->can('update_task');
        Route::delete('delete/{id}', 'delete')->can('delete_task');
    });
    
    Route::controller(SupportTicketController::class)->prefix('support-tickets')->group(function() {
        Route::get('show', 'show')->can('show_support_tickets');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_support_ticket');
        Route::put('update/{id}', 'update')->can('update_support_ticket');
        Route::delete('delete/{id}', 'delete')->can('delete_support_ticket');
    });
    
    Route::controller(RoleController::class)->prefix('roles')->group(function() {
        Route::get('show', 'show')->can('show_roles');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_role');
        Route::put('update/{id}', 'update')->can('update_role');
        Route::delete('delete/{id}', 'delete');
    });
    
    Route::controller(PermissionController::class)->prefix('permissions')->group(function() {
        Route::get('show', 'show')->can('show_permissions');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}', 'showById');
        Route::post('store', 'store')->can('create_permission');
        Route::put('update/{id}', 'update')->can('update_permission');
        Route::delete('delete/{id}', 'delete')->can('delete_permission');
    });

    Route::controller(PermissionRoleController::class)->prefix('permissions_roles')->group(function() {
        Route::post('store/{role_id}/{permission_id}', 'store');
        Route::delete('delete/{role_id}/{permission_id}', 'delete');
    });
    

    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('who-am-i','whoAmI');
        Route::get('show','show');
        Route::get('show-by-id/{user}','showById');
        Route::post('store','store');
        Route::put('update/{user}','update');
        Route::delete('delete/{user}','delete');
    });
});
