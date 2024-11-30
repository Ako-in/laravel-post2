<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/welcome');
});
// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Route::get('/posts', function () {
//     return view('posts.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::resource('posts', PostController::class);
// //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/posts/index', [PostController::class, 'index'])->name('posts.index');
// Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
// Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');

Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);
Route::resource('user', UserController::class)->middleware(['auth', 'verified']);
// Route::get('/posts', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('posts.index');

// // Route::get('/posts/create', [PostController::class, 'create'])->middleware(['auth', 'verified'])->name('posts.create');
// Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
// Route::post('/posts', [PostController::class, 'store'])->middleware(['auth', 'verified'])->name('posts.store');

// Route::get('/posts/{post}', [PostController::class, 'show'])->middleware(['auth', 'verified'])->name('posts.show');

// Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware(['auth', 'verified'])->name('posts.edit');

// Route::patch('/posts/{post}', [PostController::class, 'update'])->middleware(['auth', 'verified'])->name('posts.update');

// Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware(['auth', 'verified'])->name('posts.destroy');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//いいねのルーティング
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('likes.destroy');

//コメントのルーティング
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 認証関連のルート
require __DIR__.'/auth.php';
