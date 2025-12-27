<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/post/{slug}', [HomeController::class, 'post'])->name('post');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class);
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    
    if (auth()->attempt($credentials)) {
        return redirect()->intended('/admin/dashboard');
    }
    
    return back()->withErrors(['email' => 'Invalid credentials']);
})->name('login.post');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
