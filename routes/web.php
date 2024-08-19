<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

// Define route for home page
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Auth routes
Auth::routes(['register' => false, 'reset' => false]);

// Protect the routes with auth middleware
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/data/books-by-month', [DashboardController::class, 'getBooksByMonthData'])->name('dashboard.data.books_by_month');
    });

    // Member routes
    Route::resource('members', MemberController::class);

    // Book routes including soft deletes
    Route::prefix('books')->group(function () {
        Route::get('trashed', [BookController::class, 'trashed'])->name('books.trashed');
        Route::post('{id}/restore', [BookController::class, 'restore'])->name('books.restore');
        Route::delete('{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.force-delete');
    });
    Route::resource('books', BookController::class);

    // Category routes including soft deletes
    Route::prefix('categories')->group(function () {
        Route::get('trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
        Route::post('{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore')->middleware('role:admin');
        Route::delete('{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete')->middleware('role:admin');
    });
    Route::resource('categories', CategoryController::class);

    // Publisher routes including soft deletes
    Route::prefix('publishers')->group(function () {
        Route::get('trashed', [PublisherController::class, 'trashed'])->name('categories.trashed');
        Route::post('{id}/restore', [PublisherController::class, 'restore'])->name('categories.restore')->middleware('role:admin');
        Route::delete('{id}/force-delete', [PublisherController::class, 'forceDelete'])->name('categories.force-delete')->middleware('role:admin');
    });
    Route::resource('publishers', PublisherController::class);

    // Borrowing routes
    Route::resource('borrowings', BorrowingController::class);

    Route::resource('users', UserController::class)->only([
        'index', 'create', 'store',
    ])->middleware('role:admin');

    Route::resource('account', UserController::class)->only([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/account/{id}/edit_password', [UserController::class, 'edit_password'])->name('account.edit_password');
    Route::put('/account/{id}/update_password', [UserController::class, 'update_password'])->name('account.update_password');

    Route::get('app', [AppController::class, 'index'])->name('app.index')->middleware('role:admin');
    Route::get('app/edit', [AppController::class, 'edit'])->name('app.edit')->middleware('role:admin');
    Route::put('app/update', [AppController::class, 'update'])->name('app.update')->middleware('role:admin');
});
