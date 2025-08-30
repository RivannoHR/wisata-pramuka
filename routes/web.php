<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TouristAttractionController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AccommodationImageController;
use App\Http\Controllers\AccommodationRoomTypeController;
use App\Http\Controllers\AdminRenderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TouristAttractionImageController;
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
    Route::get('/admin', fn() => redirect(route('admin.bookings')));
    Route::get('/admin/dashboard', fn() => redirect(route('admin.bookings')));
    Route::get('/admin/products', [AdminRenderController::class, 'productRender'])->name('admin.products');
    Route::put('/admin/product/{product:id}/toggleactive', [ProductController::class, 'toggleActive'])->name('admin.products.toggle.isactive');
    Route::put('/admin/product/{product:id}/togglefeatured', [ProductController::class, 'toggleFeatured'])->name('admin.products.toggle.isfeatured');
    Route::get('/admin/product/create', [AdminRenderController::class, 'productCreateRender'])->name('admin.products.create');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/product/{product:id}/edit', [AdminRenderController::class, 'productEditRender'])->name('admin.products.edit');
    Route::post('/admin/product/{product:id}/edit', [ProductController::class, 'productEditApply'])->name('admin.products.apply');
    Route::delete('/admin/product/{product:id}/delete', [ProductController::class, 'productDelete'])->name('admin.products.delete');
    Route::delete('/admin/products/delete-all', [ProductController::class, 'deleteAll'])->name('admin.products.delete.all');

    Route::get('/admin/bookings', [AdminRenderController::class, 'bookingRender'])->name('admin.bookings');
    Route::patch('/admin/bookings/{booking:id}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.togglestatus');

    Route::get('/admin/tourist-attraction', [AdminRenderController::class, 'touristattractionRender'])->name('admin.tourist.attractions');




    // Admin Accommodation Room Types Routes
    Route::get('/admin/accommodations/{accommodation:id}/roomtypes', [AdminRenderController::class, 'accommodationRoomTypesRender'])->name('admin.accommodations.roomtypes');
    Route::post('/admin/accommodations/{accommodation}/roomtypes/create', [AccommodationRoomTypeController::class, 'create'])->name('admin.accommodations.roomtypes.create');
    Route::delete('/admin/accommodations/{accommodation}/roomtypes/{accommodationroomtype:id}/delete', [AccommodationRoomTypeController::class, 'delete'])->name('admin.accommodations.roomtypes.delete');
    Route::put('/admin/accommodations/{accommodation}/roomtypes/{accommodationroomtype:id}/edit', [AccommodationRoomTypeController::class, 'apply'])->name('admin.accommodations.roomtypes.edit');


    Route::get('/admin/accommodations', [AdminRenderController::class, 'accommodationRender'])->name('admin.accommodations');
    Route::put('/admin/accommodations/{accommodation:id}/toggleactive', [AccommodationController::class, 'toggleActive'])->name('admin.accommodations.toggle.isactive');
    Route::get('/admin/accommodations/create', [AdminRenderController::class, 'accommodationCreateRender'])->name('admin.accommodations.create');
    Route::post('/admin/accommodations/store', [AccommodationController::class, 'store'])->name('admin.accommodations.store');
    Route::get('/admin/accommodations/{accommodation:id}/edit', [AdminRenderController::class, 'accommodationEditRender'])->name('admin.accommodations.edit');
    Route::post('/admin/accommodations/{accommodation:id}/edit', [AccommodationController::class, 'apply'])->name('admin.accommodations.apply');
    Route::delete('/admin/accommodations/delete/{accommodation:id}', [AccommodationController::class, 'delete'])->name('admin.accommodations.delete');
    Route::delete('/admin/accommodations/delete-all', [AccommodationController::class, 'deleteAll'])->name('admin.accommodations.delete.all');
    Route::get('/admin/accommodations/{accommodation:id}/images', [AdminRenderController::class, 'accommodationImagesRender'])->name('admin.accommodations.images');
    Route::post('/admin/accommodations/{accommodation}/images/create', [AccommodationImageController::class, 'create'])->name('admin.accommodations.images.create');
    Route::delete('/admin/accommodations/{accommodation:id}/images/{accommodationimage:id}/delete', [AccommodationImageController::class, 'delete'])->name('admin.accommodations.images.delete');
    Route::put('/admin/accommodations/{accommodation}/images/{accommodationimage:id}/togglefeatured', [AccommodationImageController::class, 'toggleFeatured'])->name('admin.accommodations.images.toggle.isfeatured');
    Route::put('/admin/accommodations/{accommodation:id}/images/{accommodationimage:id}/edit', [AccommodationImageController::class, 'apply'])->name('admin.accommodations.images.edit');


    Route::get('/admin/tourist-attractions', [AdminRenderController::class, 'touristAttractionRender'])->name('admin.tourist-attractions');
    Route::put('/admin/tourist-attractions/{touristAttraction:id}/toggleactive', [TouristAttractionController::class, 'toggleActive'])->name('admin.tourist-attractions.toggle.isactive');
    Route::get('/admin/tourist-attractions/create', [AdminRenderController::class, 'touristAttractionCreateRender'])->name('admin.tourist-attractions.create');
    Route::post('/admin/tourist-attractions/store', [TouristAttractionController::class, 'store'])->name('admin.tourist-attractions.store');
    Route::get('/admin/tourist-attractions/{touristAttraction:id}/edit', [AdminRenderController::class, 'touristAttractionEditRender'])->name('admin.tourist-attractions.edit');
    Route::post('/admin/tourist-attractions/{touristAttraction:id}/edit', [TouristAttractionController::class, 'apply'])->name('admin.tourist-attractions.apply');
    Route::delete('/admin/tourist-attractions/delete/{touristAttraction:id}', [TouristAttractionController::class, 'delete'])->name('admin.tourist-attractions.delete');
    Route::delete('/admin/tourist-attractions/delete-all', [TouristAttractionController::class, 'deleteAll'])->name('admin.tourist-attractions.delete.all');
    Route::get('/admin/tourist-attractions/{touristAttraction:id}/images', [AdminRenderController::class, 'touristAttractionImagesRender'])->name('admin.tourist-attractions.images');
    Route::post('/admin/tourist-attractions/{touristAttraction}/images/create', [TouristAttractionImageController::class, 'create'])->name('admin.tourist-attractions.images.create');
    Route::delete('/admin/tourist-attractions/{touristAttraction:id}/images/{touristAttractionImage:id}/delete', [TouristAttractionImageController::class, 'delete'])->name('admin.tourist-attractions.images.delete');
    Route::put('/admin/tourist-attractions/{touristAttraction}/images/{touristAttractionImage:id}/togglefeatured', [TouristAttractionImageController::class, 'toggleFeatured'])->name('admin.tourist-attractions.images.toggle.isfeatured');
    Route::put('/admin/tourist-attractions/{touristAttraction:id}/images/{touristAttractionImage:id}/edit', [TouristAttractionImageController::class, 'apply'])->name('admin.tourist-attractions.images.edit');
});
