<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\CategoriesController;


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
});
Route::prefix('categories')->group(function () {
    //Lấy tất cả thể loại
    Route::get('/', [CategoriesController::class, 'index']);
    //Lấy thể loại theo id
    Route::get('/{id}', [CategoriesController::class, 'show']);
});
