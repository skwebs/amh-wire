<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class CustomerSummary extends Component
{
    public $customer;
    public $transactions;
    public $validated = false;

    #[Url]
    public $d = '';


    public function mount(Customer $customer)
    {
        if (strtotime($customer->created_at) === $this->d) {
            $this->validated = true;
            $this->customer = $customer;
            $this->transactions = $customer->transactions()->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        }
        // $this->transactions = $customer->transactions()->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
    }


    #[Title('Customer Summary')]
    public function render()
    {

        return view('livewire.v1.customer.customer-summary');
    }
}
