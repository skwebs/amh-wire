<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;

class Transactions extends Component
{
    public $customer;
    public $transactions;

    public $sortField = 'date'; // Default sorting field
    public $sortDirection = 'asc'; // Default sorting direction

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
        $this->fetchTransactions();
    }

    public function fetchTransactions()
    {
        $this->transactions = $this->customer->transactions()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->fetchTransactions();
    }

    public function render()
    {
        return view('livewire.v1.transaction.transactions2');
    }
}
