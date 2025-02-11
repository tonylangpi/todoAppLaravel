<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\TaskController;

Route::get('/persons',[PersonController::class, 'index']);
Route::post('/createPerson', [PersonController::class, 'store']);
Route::put('/updatePerson/{id}', [PersonController::class, 'update']);
Route::post('/login', [PersonController::class, 'login']);


//routes for tasks of users
Route::post('/createTaskUser/{id}', [TaskController::class, 'addTaskToPerson']);
Route::put('/updateTaskUser/{id}', [TaskController::class, 'editTaskPerson']);
Route::get('/tasksByPerson/{id}', [TaskController::class, 'taskByPerson']);