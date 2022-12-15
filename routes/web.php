<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'welcome']);

//route for viewing the create posts page
Route::get('/posts/create', [PostController::class, 'create']);
//route for sending form data via POST request to the /posts endpoint
Route::post('/posts', [PostController::class, 'store']);
//route to return a view containing all posts
Route::get('/posts', [PostController::class, 'index']);
//route to return a view containing only the authenticated user's posts
Route::get('/posts/myPosts', [PostController::class, 'myPosts']);
//route to return a view showing a specific post's details
Route::get('/posts/{id}', [PostController::class, 'show']);
//route to view an edit post form
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
//route to overwrite an existing post with updated values
Route::put('/posts/{id}', [PostController::class, 'update']);
//route to delete a post
Route::delete('/posts/{id}', [PostController::class, 'archive']);
//route to like a post
Route::put('/posts/{id}/like', [PostController::class, 'like']);
//route for commenting on a post
Route::post('/posts/{id}/comment', [PostController::class, 'comment']);

Auth::routes();
