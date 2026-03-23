<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// ログインかつメール認証済みユーザーのみ
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/item/{item}/like', [ItemController::class, 'storeLike'])->name('like.store');
    Route::delete('/item/{item}/like', [ItemController::class, 'destroyLike'])->name('like.destroy');
    Route::post('/item/{item}/comment', [ItemController::class, 'commentStore'])->name('comment.store');

    // address ルートは {item_id} より先に定義しないと /purchase/{item_id} にマッチしてしまう
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'addressEdit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'addressUpdate'])->name('purchase.address.update');

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchaseStore'])->name('purchase.store');
    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'purchaseSuccess'])->name('purchase.success');

    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/sell', [ItemController::class, 'sell'])->name('sell');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
});