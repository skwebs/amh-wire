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
        return $this->customer->balance;
    }

    public function sortBy($field)
    {
        $this->sortDir = ($field == $this->sortField) ? ($this->sortDir == 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField = $field;
        $this->fetchTransactions();
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->fetchTransactions();
    }

    public function fetchTransactions()
    {
        // Fetch transactions with the desired ordering
        $transactions = $this->customer->transactions()
            ->orderBy($this->sortField, $this->sortDir)
            ->orderBy('datetime', 'desc')
            ->get(); // Fetches data and returns a collection

        // Now group the fetched collection by date
        $this->transactions = $transactions->groupBy(function ($txn) {
            return date('Y-m-d', strtotime($txn->datetime));
        })->all();

        // dd($this->transactions);
    }

    #[Title('Transactions')]
    public function render()
    {
        return view('livewire.v1.transaction.transactions');
    }
}
