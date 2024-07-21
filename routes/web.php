<?php

use App\Livewire\V1\Customer\CreateCustomer;
use App\Livewire\V1\Customer\CustomerDetails;
use App\Livewire\V1\Customer\Customers;
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
Route::get('/', Homepage::class)->name('homepage');
// Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');


// // customer routes
// Route::get('/c', Customers::class)->name('customers');
// Route::get('/c/c', CreateCustomer::class)->name('customer.create');
// Route::get('/c/{customer}/d', CustomerDetails::class)->name('customer.details');
// Route::get('/c/{customer}/u', UpdateCustomer::class)->name('customer.update');
// // translation routes
// Route::get('/c/{customer}/t', Transactions::class)->name('customer.transactions');
// Route::get('/c/{customer}/c/t/{type}', CreateTransaction::class)->name('customer.transaction.create');
// Route::get('/c/{customer}/t/{transaction}', TransactionDetails::class)->name('customer.transaction.details');
// Route::get('/c/{customer}/t/{transaction}/u', UpdateTransaction::class)->name('customer.transaction.update');


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

require __DIR__ . '/auth.php';
