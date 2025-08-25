<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TouristAttractionController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AdminRenderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', [WelcomeController::class, 'index']);

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Tourist Attraction Routes
Route::get('/tourist-attractions', [TouristAttractionController::class, 'index'])->name('tourist-attractions.index');
Route::get('/tourist-attractions/{id}', [TouristAttractionController::class, 'show'])->name('tourist-attractions.show');

// Accommodation Routes
Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/accommodations/{id}', [AccommodationController::class, 'show'])->name('accommodations.show');

// Booking Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/transactions', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/login', fn() => view('admin.login'))->name('admin.login');

Route::post('/login', [LoginController::class, 'login']);

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Profile Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});


Route::middleware('auth', AdminMiddleware::class)->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });
    Route::delete('/admin/products/delete-all', [ProductController::class, 'deleteAllProducts'])->name('admin.products.delete_all');
    Route::get('/admin/dashboard', [AdminRenderController::class, 'dashboardRender']);
    Route::get('/admin/products', [AdminRenderController::class, 'productRender'])->name('admin.products');
    Route::get('/admin/product/create', [AdminRenderController::class, 'productCreateRender'])->name('admin.product.create');
});
