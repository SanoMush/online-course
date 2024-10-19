<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FrontController;
use App\Models\SubscribeTransaction;
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

Route::get('/', [FrontController::class ,'index'])->name('front.index');

Route::get('/details/{course:slug}', [FrontController::class ,'details'])->name('front.details');

Route::get('/category/{category:slug}', [FrontController::class ,'category'])->name('front.category');

Route::get('/pricing', [FrontController::class ,'pricing'])->name('front.pricing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Must Login Before Checkout
    Route::get('/checkout', [FrontController::class ,'checkout'])->name('front.checkout');
    Route::post('/checkout/store', [FrontController::class ,'checkout_store'])->name('front.checkout.store');

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('categories', CategoryController::class)
        ->middleware('role:owmer');

        Route::resource('teachers', TeacherController::class)
        ->middleware('role:owmer');

        Route::resource('courses', CourseController::class)
        ->middleware('role:owmer|teacher');

        Route::resource('subscribe_transactions', SubscribeTransactionController::class)
        ->middleware('role:owmer');

        Route::resource('course_videos', SubscribeTransactionController::class)
        ->middleware('role:owmer|teacher');
    });

});

require __DIR__.'/auth.php';
