<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
