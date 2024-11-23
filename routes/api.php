<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\AdvertisementController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('books')->group(function () {
    //Lấy tất cả sách
    Route::get('/', [BooksController::class, 'index']);
    //Lấy sách theo id
    Route::get('/{id}', [BooksController::class, 'show']);
    //Lấy sách theo thể loại
    Route::get('/category/{id}', [BooksController::class, 'filterByCategory']);
    //Lấy tổng sách
    Route::get('/statistics', [BooksController::class, 'getStatisticData']);
});
Route::prefix('categories')->group(function () {
    //Lấy tất cả thể loại
    Route::get('/', [CategoriesController::class, 'index']);
    //Lấy thể loại theo id
    Route::get('/{id}', [CategoriesController::class, 'show']);
});
Route::prefix('adversitiments')->group(function () {
    //Lấy quảng cáo theo id
    Route::get('/{id}', [AdvertisementController::class, 'show']);
});
