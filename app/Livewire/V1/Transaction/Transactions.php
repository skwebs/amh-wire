<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Transactions extends Component
{

    public $customer;
    public $transactions;

    public function calculateBalance()
    {
        $balance = 0;

        foreach ($this->transactions as $transaction) {
            if ($transaction->type === 'credit') {
                $balance -= $transaction->amount;
            } else {
                $balance += $transaction->amount;
            }
        }

        return $balance;
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        // $this->transactions = $customer->transactions()->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        $this->transactions = $customer->transactions()->get();
    }

    // #[Layout('layouts.wire')]
    public function render()
    {
        return view('livewire.v1.transaction.transactions');
    }
}