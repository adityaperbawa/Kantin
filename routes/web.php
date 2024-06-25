<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;

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
    return view('auth/login');
});

// Rute untuk halaman login dan register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Rute untuk proses login dan register
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Rute Sesuai Role
Route::middleware('admin')->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');

    Route::get('/manager/users', [UserController::class, 'index'])->name('manager.users.index');
    Route::get('/manager/users/create', [UserController::class, 'create'])->name('manager.users.create');
    Route::post('/manager/users', [UserController::class, 'store'])->name('manager.users.store');
    Route::get('/manager/users/{user}/edit', [UserController::class, 'edit'])->name('manager.users.edit');
    Route::put('/manager/users/{user}', [UserController::class, 'update'])->name('manager.users.update');
    Route::delete('/manager/users/{user}', [UserController::class, 'destroy'])->name('manager.users.destroy');
    Route::get('/manager/users/{id}', [UserController::class, 'show'])->name('manager.users.show');


    Route::get('/manager/tables/create', [TableController::class, 'create'])->name('manager.tables.create');
    Route::get('/manager/tables/index', [TableController::class, 'index'])->name('manager.tables.index');
    Route::get('tables/index', [TableController::class, 'index'])->name('tables.index');
    Route::post('/manager/tables/store', [TableController::class, 'store'])->name('manager.tables.store');
    Route::delete('/manager/tables/{table}', [TableController::class, 'destroy'])->name('manager.tables.destroy');

    Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu.show');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    
    // Rute untuk menampilkan riwayat pesanan
    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order.history');
    // Rute untuk menghapus pesanan
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/search', [OrderController::class, 'search'])->name('orders.search');
    
});

// Rute Kasir
Route::group(['middleware' => 'auth'], function () {
    Route::get('/kasir', [OrderController::class, 'kasir'])->name('kasir.dashboard');
    Route::match(['get', 'patch'], '/orders/{id}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/payMultiple', [OrderController::class, 'payMultiple'])->name('orders.payMultiple');
});

// Rute Dapur
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dapur', [OrderController::class, 'dapur'])->name('dapur.dashboard');
    Route::post('/orders/{id}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');

});


// Rute untuk menampilkan menu kepada pelanggan
Route::get('/menu-pelanggan', [MenuController::class, 'showMenuPelanggan'])->name('menu.order');
// Rute untuk menampilkan formulir pesanan (GET)
Route::get('/order', [OrderController::class, 'showMenu'])->name('order.show');
// Rute untuk menyimpan pesanan baru (POST)
Route::post('/order', [OrderController::class, 'store'])->name('order.store');


// Logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');