<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

// まず「ログインしていること」を大前提にする
Route::middleware(['auth'])->group(function () {
    
    // ログインさえしていればできること
    Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])->name('like.toggle');
    Route::post('/item/{item}/comment', [ItemController::class, 'commentStore'])->name('comment.store');

    // ログイン ＋ 「メール認証まで終わっている人」だけができること
    Route::middleware(['verified'])->group(function () {
        Route::get('/sell', [ItemController::class, 'sell'])->name('sell');
        Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
        Route::get('/item/{item}/purchase', [ItemController::class, 'purchase'])->name('item.purchase');
        Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });
});