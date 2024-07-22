<?php

namespace App\Livewire\V1;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Homepage extends Component
{
    public $transactions;
    public $balance;
    public $customerNumber;

    public function mount()
    {
        // Calculate debits and credits directly in the database
        $debits = Transaction::where('type', 'debit')->sum('amount');
        $credits = Transaction::where('type', 'credit')->sum('amount');

        // Calculate balance
        $this->balance =  $debits - $credits;

        // Retrieve and cache customer count
        $this->customerNumber = Cache::remember('customer_count', 60, function () {
            return Customer::count();
        });

        // Optionally, limit the number of transactions retrieved if only a subset is needed
        $this->transactions = Transaction::latest()->take(100)->get(); // Example: Get the latest 100 transactions
    }

    public function render()
    {
        // dd($this->balance);
        return view('livewire.v1.homepage');
    }
}