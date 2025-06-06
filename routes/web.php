<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('login');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('api.products.search');

Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::post('/user/{user}/follow', [App\Http\Controllers\UserController::class, 'follow'])->name('user.follow');
    Route::delete('/user/{user}/follow', [App\Http\Controllers\UserController::class, 'unfollow'])->name('user.unfollow');
    Route::get('/user/{user}/followers', [App\Http\Controllers\UserController::class, 'followers'])->name('user.followers');
    Route::get('/user/{user}/following', [App\Http\Controllers\UserController::class, 'following'])->name('user.following');
    
    Route::resource('bike-categories', App\Http\Controllers\BikeCategoryController::class);
    Route::resource('part-categories', App\Http\Controllers\PartCategoryController::class);
    
    Route::get('/reviews/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/like', [App\Http\Controllers\ReviewController::class, 'like'])->name('reviews.like');
    Route::delete('/reviews/{review}/images/{image}', [App\Http\Controllers\ReviewController::class, 'deleteImage'])->name('reviews.images.delete');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-admin', [App\Http\Controllers\Admin\AdminController::class, 'toggleUserAdmin'])->name('users.toggle-admin');
    
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('reviews.show');
    Route::patch('/reviews/{review}/toggle-visibility', [App\Http\Controllers\Admin\ReviewController::class, 'toggleVisibility'])->name('reviews.toggle-visibility');
    Route::post('/reviews/bulk-toggle-visibility', [App\Http\Controllers\Admin\ReviewController::class, 'bulkToggleVisibility'])->name('reviews.bulk-toggle-visibility');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    Route::get('/bike-categories', [App\Http\Controllers\Admin\CategoryController::class, 'bikeCategories'])->name('bike-categories');
    Route::get('/bike-categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'createBikeCategory'])->name('bike-categories.create');
    Route::post('/bike-categories', [App\Http\Controllers\Admin\CategoryController::class, 'storeBikeCategory'])->name('bike-categories.store');
    Route::get('/bike-categories/{bikeCategory}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'editBikeCategory'])->name('bike-categories.edit');
    Route::put('/bike-categories/{bikeCategory}', [App\Http\Controllers\Admin\CategoryController::class, 'updateBikeCategory'])->name('bike-categories.update');
    Route::delete('/bike-categories/{bikeCategory}', [App\Http\Controllers\Admin\CategoryController::class, 'destroyBikeCategory'])->name('bike-categories.destroy');
    
    Route::get('/part-categories', [App\Http\Controllers\Admin\CategoryController::class, 'partCategories'])->name('part-categories');
    Route::get('/part-categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'createPartCategory'])->name('part-categories.create');
    Route::post('/part-categories', [App\Http\Controllers\Admin\CategoryController::class, 'storePartCategory'])->name('part-categories.store');
    Route::get('/part-categories/{partCategory}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'editPartCategory'])->name('part-categories.edit');
    Route::put('/part-categories/{partCategory}', [App\Http\Controllers\Admin\CategoryController::class, 'updatePartCategory'])->name('part-categories.update');
    Route::delete('/part-categories/{partCategory}', [App\Http\Controllers\Admin\CategoryController::class, 'destroyPartCategory'])->name('part-categories.destroy');
    
    Route::get('/settings', [App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');
});
