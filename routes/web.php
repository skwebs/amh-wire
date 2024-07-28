<?php

use App\Livewire\V1\Customer\CreateCustomer;
use App\Livewire\V1\Customer\CustomerDetails;
use App\Livewire\V1\Customer\Customers;
use App\Livewire\V1\Customer\CustomerSummary;
use App\Livewire\V1\Customer\UpdateCustomer;
use App\Livewire\V1\Homepage;
use App\Livewire\V1\Transaction\CreateTransaction;
use App\Livewire\V1\Transaction\TransactionDetails;
use App\Livewire\V1\Transaction\Transactions;
use App\Livewire\V1\Transaction\UpdateTransaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return redirect('/c');
    return view('homepage');
});
Route::get('/customer/{customer}/summary', CustomerSummary::class)->name('customer.summary');
Route::middleware('auth')->group(function () {
    Route::get('/', Homepage::class)->name('homepage');
    // Customer Public Route

    // Customer routes
    Route::get('/customers', Customers::class)->name('customers');
    Route::get('/customers/create', CreateCustomer::class)->name('customer.create');
    Route::get('/customers/{customer}/details', CustomerDetails::class)->name('customer.details');
    Route::get('/customers/{customer}/edit', UpdateCustomer::class)->name('customer.update');

    // Transaction routes
    Route::get('/customers/{customer}/transactions', Transactions::class)->name('customer.transactions');
    Route::get('/customers/{customer}/transactions/create', CreateTransaction::class)->name('customer.transaction.create');
    Route::get('/customers/{customer}/transactions/{transaction}', TransactionDetails::class)->name('customer.transaction.details');
    Route::get('/customers/{customer}/transactions/{transaction}/edit', UpdateTransaction::class)->name('customer.transaction.update');
});
require __DIR__ . '/auth.php';
