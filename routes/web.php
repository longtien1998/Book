<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProfileController as AdminProfileController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\BooksController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdvertisementController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\CommentController as UserCommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile'); // Add this name
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comment
    Route::get('books/{bookId}/comments', [UserCommentController::class, 'getBookComments']);
    Route::post('comments', [UserCommentController::class, 'store']);
    Route::put('comments/{id}', [UserCommentController::class, 'update']);
    Route::delete('comments/{id}', [UserCommentController::class, 'destroy']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/fontawesome', [HomeController::class, 'fontawesome'])->name('fontawesome');
    Route::get('/basic-table', [HomeController::class, 'basic_table'])->name('basic-table');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    // Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    // Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');

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
    Route::group([
        'prefix' => 'users',
        'controller' => UserController::class,
        'as' => 'users.',
    ], function () {
        Route::get('/list',  'index')->name('list');
        Route::get('/add',  'create')->name('add');
        Route::post('/store',  'store')->name('store');
        Route::get('/edit/{id}',  'edit')->name('edit');
        Route::put('/update/{id}',  'update')->name('update');
        Route::delete('/{id}/delete',  'delete')->name('delete');
        Route::post('/delete-list',  'delete_list_users')->name('delete-list');
        Route::post('/search',  'search')->name('search');

        Route::group([
            'prefix' => 'trash',
            'as' => 'trash.',
        ], function () {
            Route::get('/list',  'list_trash_users')->name('list');
            Route::post('/search',  'search_trash')->name('search');
            Route::post('/restore',  'restore_trash_users')->name('restore');
            Route::get('/restore-all',  'restore_all_users')->name('restore-all');
            Route::post('/delete',  'delete_trash_users')->name('delete');
            Route::get('/{id}/destroy',  'destroy_trash_users')->name('destroy');

        });
    });

        //Quảng cáo
        Route::group([
            'prefix' => 'advertisements',
            'controller' => AdvertisementController::class,
            'as' => 'advertisements.',
        ], function () {
            Route::get('/index',  'index')->name('index');
            Route::get('/create',  'create')->name('create');
            Route::post('/store',  'store')->name('store');
            Route::get('/edit/{id}',  'edit')->name('edit');
            Route::put('/update/{id}',  'update')->name('update');
            Route::delete('/{id}/delete',  'delete')->name('delete');
            Route::post('/delete-list',  'delete_list_advertisement')->name('delete-list');
            Route::post('/search',  'search')->name('search');

            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ], function () {
                Route::get('/list',  'list_trash_advertisement')->name('list');
                Route::post('/search',  'search_trash')->name('search');
                Route::post('/restore',  'restore_trash_advertisement')->name('restore');
                Route::get('/restore-all',  'restore_all_advertisement')->name('restore-all');
                Route::post('/delete',  'delete_trash_advertisement')->name('delete');
                Route::get('/{id}/destroy',  'destroy_trash_advertisement')->name('destroy');

            });


    });

    Route::prefix('coupon')->group(function () {
        Route::get('index', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('store', [CouponController::class, 'store'])->name('coupon.store');
        Route::get('edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::post('update/{id}', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('destroy/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');
        Route::post('find', [CouponController::class, 'find'])->name('coupon.find');
    });

    Route::group([
        'prefix' => 'comments',
        'controller' => CommentController::class,
        'as' => 'comments.',
    ], function () {
        Route::get('/list',  'index')->name('list');
        Route::delete('/{id}/delete',  'delete')->name('delete');
        Route::post('/delete-list',  'delete_list_comments')->name('delete-list');
        Route::post('/search',  'search')->name('search');

        Route::group([
            'prefix' => 'trash',
            'as' => 'trash.',
        ], function () {
            Route::get('/list',  'list_trash_comments')->name('list');
            Route::post('/search',  'search_trash')->name('search');
            Route::post('/restore',  'restore_trash_comments')->name('restore');
            Route::get('/restore-all',  'restore_all_comments')->name('restore-all');
            Route::post('/delete',  'delete_trash_comments')->name('delete');
            Route::get('/{id}/destroy',  'destroy_trash_comments')->name('destroy');

        });
    });

});
require __DIR__.'/auth.php';
