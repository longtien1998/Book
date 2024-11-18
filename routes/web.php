<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\BooksController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/fontawesome', [HomeController::class, 'fontawesome'])->name('fontawesome');
Route::get('/basic-table', [HomeController::class, 'basic_table'])->name('basic-table');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/list', [ProfileController::class, 'index'])->name('profile');
Route::group([
    'prefix' => 'categories',
    'controller' => CategoriesController::class,
    'as' => 'categories.',
], function () {
    Route::get('/list',  'index')->name('list');
    Route::get('/add',  'create')->name('add');
    Route::post('/store',  'store')->name('store');
    Route::get('/edit/{id}',  'edit')->name('edit');
    Route::put('/update/{id}',  'update')->name('update');
    Route::delete('/{id}/delete',  'delete')->name('delete');
    Route::post('/delete-list',  'delete_list_categories')->name('delete-list');
    Route::post('/search',  'search')->name('search');

    Route::group([
        'prefix' => 'trash',
        'as' => 'trash.',
    ], function () {
        Route::get('/list',  'list_trash_categories')->name('list');
        Route::post('/search',  'search_trash')->name('search');
        Route::post('/restore',  'restore_trash_categories')->name('restore');
        Route::get('/restore-all',  'restore_all_categories')->name('restore-all');
        Route::post('/delete',  'delete_trash_categories')->name('delete');
        Route::get('/{id}/destroy',  'destroy_trash_categories')->name('destroy');

    });

});
Route::group([
    'prefix' => 'books',
    'controller' => BooksController::class,
    'as' => 'books.',
], function () {
    Route::get('/list',  'index')->name('list');
    Route::get('/add',  'create')->name('add');
    Route::post('/store',  'store')->name('store');
    Route::get('/edit/{id}',  'edit')->name('edit');
    Route::put('/update/{id}',  'update')->name('update');
    Route::delete('/{id}/delete',  'delete')->name('delete');
    Route::post('/delete-list',  'delete_list_books')->name('delete-list');
    Route::post('/search',  'search')->name('search');

    Route::group([
        'prefix' => 'trash',
        'as' => 'trash.',
    ], function () {
        Route::get('/list',  'list_trash_books')->name('list');
        Route::post('/search',  'search_trash')->name('search');
        Route::post('/restore',  'restore_trash_books')->name('restore');
        Route::get('/restore-all',  'restore_all_books')->name('restore-all');
        Route::post('/delete',  'delete_trash_books')->name('delete');
        Route::get('/{id}/destroy',  'destroy_trash_books')->name('destroy');

    });

});



