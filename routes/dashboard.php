<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\SecondProductController;
use App\Models\SecondProduct;

Route::middleware('auth')->group(function () {

    Route::resource('products', ProductController::class);
    Route::get('scan-barcode', [ProductController::class, 'scanBarcode'])->name('products.scanBarcode');
    Route::post('/products/price', [ProductController::class, 'getPriceByBarcode'])->name('products.getPriceByBarcode');

    Route::post('products/uploadBarcode', [ProductController::class, 'uploadBarcode'])->name('products.uploadBarcode');

    Route::resource('second-products', SecondProductController::class);

    Route::post('/products/import', [SecondProductController::class, 'import'])->name('products.import');
    Route::post('/second-products/{id}/reduce-unit-plus', [SecondProductController::class, 'reduceUnit'])->name('second-products.reducePlus');
    Route::post('/second-products/{id}/reduce-unit-minus', [SecondProductController::class, 'reduceUnit2'])->name('second-products.reduceMinus');

    Route::get('calculator', function () {
        return view('pages.calculator');
    })->name('calculator');


    Route::get('/currency_rates', [CurrencyRateController::class, 'index'])->name('currency_rates.index');
    Route::get('/currency_rates/create', [CurrencyRateController::class, 'create'])->name('currency_rates.create');
    Route::post('/currency_rates', [CurrencyRateController::class, 'store'])->name('currency_rates.store');
    Route::get('/currency_rates/edit', [CurrencyRateController::class, 'edit'])->name('currency_rates.edit');
    Route::put('/currency_rates/update', [CurrencyRateController::class, 'update'])->name('currency_rates.update');
});
