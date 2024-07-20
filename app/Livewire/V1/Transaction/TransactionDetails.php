<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TransactionDetails extends Component
{
    public $customer;
    public $transaction;



    public function mount(Customer $customer, Transaction $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        // $this->transactions = $customer->transactions()->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        // $this->transactions = $customer->transactions()->get();
    }

    // #[Layout('layouts.wire')]
    public function render()
    {
        return view('livewire.v1.transaction.transaction-details');
    }
}