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
    public $sortDir = 'desc';
    public $sortField = 'date';

    public function calculateBalance()
    {
        return $this->customer->balance;
    }

    public function sortBy($field)
    {
        $this->sortDir = ($field == $this->sortField) ? ($this->sortDir == 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField = $field;
        $this->transactions = $this->customer->transactions()->orderBy($this->sortField, $this->sortDir)->get();
    }

    // public function sortBy($field)
    // {
    //     if ($this->sortField === $field) {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortDirection = 'asc';
    //     }

    //     $this->sortField = $field;
    //     $this->fetchTransactions();
    // }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->transactions = $customer->transactions()->orderBy($this->sortField, $this->sortDir)->get();
    }

    // public function fetchTransactions()
    // {
    //     $this->transactions = $this->customer->transactions()
    //         ->orderBy($this->sortField, $this->sortDir)
    //         ->get();
    // }

    // #[Layout('layouts.wire')]
    public function render()
    {
        // $this->transactions = $this->customer->transactions()->orderBy($this->sortField, $this->sortDir)->get();
        return view('livewire.v1.transaction.transactions');
    }
}
