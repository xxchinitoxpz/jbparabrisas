<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\DivineAngelJobController;
use App\Http\Controllers\Admin\CruceroJaenJobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin CRUDs
    Route::resource('productos', ProductController::class)->names('admin.product')->except(['show']);
    Route::resource('proveedores', SupplierController::class)->names('admin.supplier')->except(['show']);
    Route::resource('clientes', CustomerController::class)->names('admin.customer')->except(['show']);
    Route::resource('inventarios', InventoryController::class)->names('admin.inventory')->except(['show']);
    Route::resource('trabajos-angel-divino', DivineAngelJobController::class)->names('admin.divine_angel_job')->except(['show']);
    Route::resource('trabajos-crucero-jaen', CruceroJaenJobController::class)->names('admin.crucero_jaen_job')->except(['show']);
});

require __DIR__.'/auth.php';
