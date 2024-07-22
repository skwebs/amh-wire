<?php

namespace App\Livewire\V1;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;

class Homepage extends Component
{
    public $transactions;
    public $balance;
    public $customerNumber;

    public function mount()
    {
        // Retrieve all transactions
        $this->transactions = Transaction::all();

        // Calculate debits and credits
        $debits = $this->transactions->where('type', 'debit')->sum('amount');
        $credits = $this->transactions->where('type', 'credit')->sum('amount');

        // Calculate balance
        $this->balance =  $debits - $credits;
        $this->customerNumber = Customer::count();
    }

    public function render()
    {
        // dd($this->balance);
        return view('livewire.v1.homepage');
    }
}