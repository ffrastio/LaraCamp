<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', [UserController::class, 'login'])->name('login');

// Configuration Socialite
Route::get('sign-in-google', [UserController::class, 'google'])->name('sign.in.google');
Route::get('auth/google/callback', [UserController::class, 'handleProviderCallBack'])->name('user.google.callback');

Route::middleware(['auth'])->group(function () {
    //Checkout Routes
    Route::get('/success-checkout', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
