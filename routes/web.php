<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckout;
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

Route::get('payment/success', [CheckoutController::class, 'midtransCallBack']);
Route::post('payment/success', [CheckoutController::class, 'midtransCallBack']);

Route::middleware(['auth'])->group(function () {
    //Checkout Routes
    Route::get('/success-checkout', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('EnsureUserRole:user');
    Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'index'])->name('checkout')->middleware('EnsureUserRole:user');
    Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('EnsureUserRole:user');
    //dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // user Dashboard
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('EnsureUserRole:user')->group(function () {
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

    // admin Dashboard
    Route::prefix('admin/dashboard')->namespace('Admin')->name('admin.')->middleware('EnsureUserRole:admin')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::post('checkout/{checkout}', [AdminCheckout::class, 'update'])->name('checkout.update');
    });
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
