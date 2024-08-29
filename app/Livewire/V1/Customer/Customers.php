<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Customers extends Component
{

    public $customers;

    public function mount()
    {
        // Load customers with their latest transaction date and balance
        $this->customers = Customer::with('latestTransaction')->get();
    }

    public function loadCustomers()
    {
        // $this->customers = Customer::with(['transactions' => function ($query) {
        //     $query->select('id',  'amount', 'type', 'created_at');
        // }])
        //     ->get()
        //     ->map(function ($customer) {
        //         $customer->balance = $customer->transactions->reduce(function ($carry, $transaction) {
        //             return $carry + ($transaction->type === 'debit' ? $transaction->amount : -$transaction->amount);
        //         }, 0);
        //         return $customer;
        //     });

    }
    // #[Layout('layouts.wire')]
    #[Title('Customer List')]
    public function render()
    {
        // dd($this->customers);
        return view('livewire.v1.customer.customers');
    }
}
