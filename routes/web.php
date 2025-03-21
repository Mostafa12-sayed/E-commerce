<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SocialController;
use App\Models\Cart;
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



// login and register routes
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'view'])->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('login');
  Route::get('/register', [RegisterController::class, 'view'])->name('register');
  Route::post('/register', [RegisterController::class, 'store'])->name('register');
  Route::get('login/{provider}', [SocialController::class, 'redirect'])->name('social.login');
  Route::get('login/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
});


// cart checkout and payment routes
Route::middleware('auth')->group(function () {
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
  Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
  Route::get('/checkout/payment/{orderId}', [PaymentController::class, 'checkout'])->name('checkout.payment');
  Route::get('/payment/response', [PaymentController::class, 'responseCallback'])->name('payment.response');
});



// payment success and failed routes
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('cart', CartController::class);
Route::get('/confirm-order', [CartController::class, 'confirmOrder'])->name('cart.confirm-order');

//  payment callback route
Route::get('/payment/callback', [PaymentController::class, 'processCallback'])->name('payment.callback');
