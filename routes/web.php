<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TouristAttractionController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AccommodationImageController;
use App\Http\Controllers\AdminRenderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleImageController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TouristAttractionImageController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Tourist Attraction Routes
Route::get('/tourist-attractions', [TouristAttractionController::class, 'index'])->name('tourist-attractions.index');
Route::get('/tourist-attractions/{id}', [TouristAttractionController::class, 'show'])->name('tourist-attractions.show');
Route::post('/tourist-attractions/{id}/review', [TouristAttractionController::class, 'storeReview'])->name('tourist-attractions.review.store');

// Accommodation Routes
Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/accommodations/{id}', [AccommodationController::class, 'show'])->name('accommodations.show');

// Article Routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.post');
});

// Logout Routes (Authenticated Only)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');
});

// Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('bookings.review.store');
    Route::patch('/bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/transactions', [BookingController::class, 'index'])->name('transactions.index');
    Route::post('/articles/{article}/comments', [ArticleCommentController::class, 'store'])->name('articles.comments.store');
    Route::delete('/articles/comments/{comment}', [ArticleCommentController::class, 'destroy'])->name('articles.comments.destroy');
});

// Admin Routes (Authenticated Admin Users)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminRenderController::class, 'dashboardRender'])->name('admin.dashboard');

    // User Management
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    Route::delete('/admin/users/delete-all', [AdminUserController::class, 'deleteAll'])->name('admin.users.delete-all');

    // Product Management
    Route::get('/admin/products', [AdminRenderController::class, 'productRender'])->name('admin.products');
    Route::put('/admin/products/{product:id}/toggleactive', [ProductController::class, 'toggleActive'])->name('admin.products.toggle.isactive');
    Route::put('/admin/products/{product:id}/togglefeatured', [ProductController::class, 'toggleFeatured'])->name('admin.products.toggle.isfeatured');
    Route::get('/admin/products/create', [AdminRenderController::class, 'productCreateRender'])->name('admin.products.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product:id}/edit', [AdminRenderController::class, 'productEditRender'])->name('admin.products.edit');
    Route::post('/admin/products/{product:id}/edit', [ProductController::class, 'apply'])->name('admin.products.apply');
    Route::delete('/admin/products/delete/{product:id}', [ProductController::class, 'delete'])->name('admin.products.delete');
    Route::delete('/admin/products/delete-all', [ProductController::class, 'deleteAll'])->name('admin.products.delete.all');

    // Accommodation Management
    Route::get('/admin/accommodations', [AdminRenderController::class, 'accommodationRender'])->name('admin.accommodations');
    Route::put('/admin/accommodations/{accommodation:id}/toggleactive', [AccommodationController::class, 'toggleActive'])->name('admin.accommodations.toggle.isactive');
    Route::get('/admin/accommodations/create', [AdminRenderController::class, 'accommodationCreateRender'])->name('admin.accommodations.create');
    Route::post('/admin/accommodations/store', [AccommodationController::class, 'store'])->name('admin.accommodations.store');
    Route::get('/admin/accommodations/{accommodation:id}/edit', [AdminRenderController::class, 'accommodationEditRender'])->name('admin.accommodations.edit');
    Route::post('/admin/accommodations/{accommodation:id}/edit', [AccommodationController::class, 'apply'])->name('admin.accommodations.apply');
    Route::delete('/admin/accommodations/delete/{accommodation:id}', [AccommodationController::class, 'delete'])->name('admin.accommodations.delete');
    Route::delete('/admin/accommodations/delete-all', [AccommodationController::class, 'deleteAll'])->name('admin.accommodations.delete.all');
    
    // Accommodation Images
    Route::get('/admin/accommodations/{accommodation:id}/images', [AdminRenderController::class, 'accommodationImagesRender'])->name('admin.accommodations.images');
    Route::post('/admin/accommodations/{accommodation}/images/create', [AccommodationImageController::class, 'create'])->name('admin.accommodations.images.create');
    Route::delete('/admin/accommodations/{accommodation:id}/images/{accommodationimage:id}/delete', [AccommodationImageController::class, 'delete'])->name('admin.accommodations.images.delete');
    Route::put('/admin/accommodations/{accommodation}/images/{accommodationimage:id}/togglefeatured', [AccommodationImageController::class, 'toggleFeatured'])->name('admin.accommodations.images.toggle.isfeatured');
    Route::put('/admin/accommodations/{accommodation:id}/images/{accommodationimage:id}/edit', [AccommodationImageController::class, 'apply'])->name('admin.accommodations.images.edit');

    // Accommodation Reviews
    Route::get('/admin/accommodations/{accommodation}/reviews', [AdminReviewController::class, 'accommodationReviews'])->name('admin.accommodations.reviews');
    Route::delete('/admin/accommodations/reviews/{review}', [AdminReviewController::class, 'deleteAccommodationReview'])->name('admin.accommodations.reviews.delete');
    Route::post('/admin/accommodations/{accommodation}/reviews/bulk-delete', [AdminReviewController::class, 'bulkDeleteAccommodationReviews'])->name('admin.accommodations.reviews.bulk-delete');

    // Tourist Attraction Management
    Route::get('/admin/tourist-attractions', [AdminRenderController::class, 'touristAttractionRender'])->name('admin.tourist-attractions');
    Route::put('/admin/tourist-attractions/{touristAttraction:id}/toggleactive', [TouristAttractionController::class, 'toggleActive'])->name('admin.tourist-attractions.toggle.isactive');
    Route::get('/admin/tourist-attractions/create', [AdminRenderController::class, 'touristAttractionCreateRender'])->name('admin.tourist-attractions.create');
    Route::post('/admin/tourist-attractions/store', [TouristAttractionController::class, 'store'])->name('admin.tourist-attractions.store');
    Route::get('/admin/tourist-attractions/{touristAttraction:id}/edit', [AdminRenderController::class, 'touristAttractionEditRender'])->name('admin.tourist-attractions.edit');
    Route::post('/admin/tourist-attractions/{touristAttraction:id}/edit', [TouristAttractionController::class, 'apply'])->name('admin.tourist-attractions.apply');
    Route::delete('/admin/tourist-attractions/delete/{touristAttraction:id}', [TouristAttractionController::class, 'delete'])->name('admin.tourist-attractions.delete');
    Route::delete('/admin/tourist-attractions/delete-all', [TouristAttractionController::class, 'deleteAll'])->name('admin.tourist-attractions.delete.all');
    
    // Tourist Attraction Images
    Route::get('/admin/tourist-attractions/{touristAttraction:id}/images', [AdminRenderController::class, 'touristAttractionImagesRender'])->name('admin.tourist-attractions.images');
    Route::post('/admin/tourist-attractions/{touristAttraction}/images/create', [TouristAttractionImageController::class, 'create'])->name('admin.tourist-attractions.images.create');
    Route::delete('/admin/tourist-attractions/{touristAttraction:id}/images/{touristAttractionImage:id}/delete', [TouristAttractionImageController::class, 'delete'])->name('admin.tourist-attractions.images.delete');
    Route::put('/admin/tourist-attractions/{touristAttraction}/images/{touristAttractionImage:id}/togglefeatured', [TouristAttractionImageController::class, 'toggleFeatured'])->name('admin.tourist-attractions.images.toggle.isfeatured');
    Route::put('/admin/tourist-attractions/{touristAttraction:id}/images/{touristAttractionImage:id}/edit', [TouristAttractionImageController::class, 'apply'])->name('admin.tourist-attractions.images.edit');

    // Tourist Attraction Reviews
    Route::get('/admin/tourist-attractions/{attraction}/reviews', [AdminReviewController::class, 'touristAttractionReviews'])->name('admin.tourist-attractions.reviews');
    Route::delete('/admin/tourist-attractions/reviews/{review}', [AdminReviewController::class, 'deleteTouristAttractionReview'])->name('admin.tourist-attractions.reviews.delete');
    Route::post('/admin/tourist-attractions/{attraction}/reviews/bulk-delete', [AdminReviewController::class, 'bulkDeleteTouristAttractionReviews'])->name('admin.tourist-attractions.reviews.bulk-delete');

    // Article Management
    Route::get('/admin/articles', [AdminRenderController::class, 'articleRender'])->name('admin.articles');
    Route::get('/admin/articles/create', [AdminRenderController::class, 'articleCreateRender'])->name('admin.articles.create');
    Route::post('/admin/articles/store', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/{article:id}/edit', [AdminRenderController::class, 'articleEditRender'])->name('admin.articles.edit');
    Route::post('/admin/articles/{article:id}/edit', [ArticleController::class, 'apply'])->name('admin.articles.apply');
    Route::delete('/admin/articles/delete/{article:id}', [ArticleController::class, 'delete'])->name('admin.articles.delete');
    Route::delete('/admin/articles/delete-all', [ArticleController::class, 'deleteAll'])->name('admin.articles.delete.all');
    
    // Article comment management routes
    Route::get('/admin/articles/{article}/comments', [AdminReviewController::class, 'articleComments'])->name('admin.articles.comments');
    Route::delete('/admin/articles/comments/{comment}', [AdminReviewController::class, 'deleteArticleComment'])->name('admin.articles.comments.delete');
    Route::post('/admin/articles/{article}/comments/bulk-delete', [AdminReviewController::class, 'bulkDeleteArticleComments'])->name('admin.articles.comments.bulk-delete');
    
    // Article Images
    Route::get('/admin/articles/{article:id}/images', [AdminRenderController::class, 'articleImagesRender'])->name('admin.articles.images');
    Route::post('/admin/articles/{article}/images/create', [ArticleImageController::class, 'create'])->name('admin.articles.images.create');
    Route::delete('/admin/articles/{article:id}/images/{articleImage:id}/delete', [ArticleImageController::class, 'delete'])->name('admin.articles.images.delete');
    Route::put('/admin/articles/{article}/images/{articleImage:id}/togglefeatured', [ArticleImageController::class, 'toggleFeatured'])->name('admin.articles.images.toggle.isfeatured');
    Route::put('/admin/articles/{article:id}/images/{articleImage:id}/edit', [ArticleImageController::class, 'apply'])->name('admin.articles.images.edit');

    // Booking Management
    Route::get('/admin/bookings', [AdminRenderController::class, 'bookingRender'])->name('admin.bookings');
    Route::patch('/admin/bookings/{booking}/togglestatus', [BookingController::class, 'updateStatus'])->name('admin.bookings.togglestatus');
});
