<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);
Route::get('/', function () {
     return redirect()->route('tasks.index'); 
    });