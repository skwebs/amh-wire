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


// customer routes
Route::get('/c', Customers::class)->name('customers');
Route::get('/c/c', CreateCustomer::class)->name('customer.create');
Route::get('/c/d/{customer}', CustomerDetails::class)->name('customer.details');
Route::get('/u/c/{customer}', UpdateCustomer::class)->name('customer.update');
// translation routes
Route::get('/c/{customer}/t', Transactions::class)->name('customer.transactions');
Route::get('/c/{customer}/c/t/{type}', CreateTransaction::class)->name('customer.transaction.create');
Route::get('/c/{customer}/t/d/{transaction}', TransactionDetails::class)->name('customer.transaction.details');
Route::get('/c/{customer}/u/t/{transaction}', UpdateTransaction::class)->name('customer.transaction.update');

require __DIR__ . '/auth.php';
