<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;

class Transactions extends Component
{
    public $customer;
    public $transactions;
    public $sortDir = 'desc';
    public $sortField = 'datetime';

    public function calculateBalance()
    {
        // Optionally compute balance dynamically if not stored in the model
        return $this->customer->balance ?? $this->customer->transactions()->sum('amount');
    }

    public function sortBy($field)
    {
        $this->sortDir = ($field === $this->sortField) ? ($this->sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField = $field;
        $this->fetchTransactions();
    }

    public function mount(Customer $customer)
    {
        if (!$customer->exists) {
            // Handle invalid customer (e.g., redirect or show error)
            abort(404, 'Customer not found');
        }
        $this->customer = $customer;
        $this->fetchTransactions();
    }

    public function fetchTransactions()
    {
        $this->transactions = $this->customer->transactions()
            ->orderBy($this->sortField, $this->sortDir)
            ->get()
            ->groupBy(fn($txn) => $txn->datetime->format('Y-m-d'))
            ->all();
    }

    #[Title('Transactions')]
    public function render()
    {
        return view('livewire.v1.transaction.transactions', [
            'balance' => $this->calculateBalance(),
        ]);
    }
}
