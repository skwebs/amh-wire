<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerDetails extends Component
{
    // public function render()
    // {
    //     return view('livewire.customer-details');
    // }
    public $customerId;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
    }

    public function render()
    {
        $customer = Customer::with('journalEntries')->findOrFail($this->customerId);
        $entries = $customer->journalEntries;

        $balance = 0;
        $entries = $entries->map(function ($entry) use (&$balance) {
            if ($entry->type === 'debit') {
                $balance -= $entry->amount;
            } else {
                $balance += $entry->amount;
            }
            $entry->balance = $balance;
            return $entry;
        });

        return view('livewire.customer-details', compact('customer', 'entries'));
    }
}
