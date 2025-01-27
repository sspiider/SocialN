<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

//USERCONTROLLER

//route to display the right homepage (if Auth or NOT)
Route::get('/', [UserController::class,'showCorrectHomepage'])->name('login');

//route of form register in homepage
Route::post('/register', [UserController::class,'register'])->middleware('guest');
//route of form login in layout
Route::post('/login', [UserController::class,'login'])->middleware('guest');

//route of form logout in layout
Route::post('/logout', [UserController::class,'logout'])->middleware('auth');

//____________________________________________________//

//POSTCONTROLLER

//CRUD
Route::get('/createPost',[PostController::class,'showCreateForm'])->middleware('auth');
Route::post('/createPost',[PostController::class,'storeNNewPost'])->middleware('auth');
Route::get('/post/{post:id}',[PostController::class,'viewSinglePost']);
// d après policy(/app/Policies/PostPolicy.php) si l utilisateur peut supprimer, sinon interception
Route::delete('/post/{post:id}',[PostController::class,'delete'])->middleware('can:delete,post');
//d après policy(/app/Policies/PostPolicy.php) si l utilisateur peut modifier, sinon interception
Route::get('/post/{post:id}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post:id}',[PostController::class,'update'])->middleware('can:update,post');
//Profile

Route::get('/profile/{user:username}',[UserController::class,'profile'])->middleware('auth');