<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
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
        // $this->transactions = $this->customer->transactions()->orderBy($this->sortField, $this->sortDir)->orderBy('created_at', 'desc')->get();
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


    // #[Layout('layouts.wire')]
    #[Title('Transactions')]
    public function render()
    {
        // $this->transactions = $this->customer->transactions()->orderBy($this->sortField, $this->sortDir)->get();
        return view('livewire.v1.transaction.transactions');
    }
}
