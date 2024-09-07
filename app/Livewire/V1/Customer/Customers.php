<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;

class Customers extends Component
{
    public $customers;

    public function mount()
    {
        // Load customers with their latest transaction date and balance
        $this->customers = Customer::with('latestTransaction')->get();

        // dd($this->customers[0]->latest_transaction);
    }

    #[Title('Customer List')]
    public function render()
    {
        return view('livewire.v1.customer.customers');
    }
}
