<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerList extends Component
{
    public function render()
    {

        $customers = Customer::with('latestJournalEntry')->get();
        // return view('livewire.customer-list');
        return view('livewire.customer-list', compact('customers'));
    }
}
