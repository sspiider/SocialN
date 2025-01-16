<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

//USERCONTROLLER

//route to display the right homepage (if Auth or NOT)
Route::get('/', [UserController::class,'showCorrectHomepage']);

//route of form register in homepage
Route::post('/register', [UserController::class,'register']);
//route of form login in layout
Route::post('/login', [UserController::class,'login']);

//route of form logout in layout
Route::post('/logout', [UserController::class,'logout']);

//____________________________________________________//

//POSTCONTROLLER

Route::get('/createPost',[PostController::class,'showCreateForm']);