<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CustomerDetails extends Component
{
    public $customer;

    public $balance;

    public $latestTransaction;

    // #[Layout('layouts.wire')]
    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $credit = $customer->transactions()->where('type', 'credit')->sum('amount');
        $debit = $customer->transactions()->where('type', 'debit')->sum('amount');
        $this->balance = $credit - $debit;
        $this->latestTransaction = $customer->transactions()->first();
    }


    public function delete()
    {
        $this->customer->delete();
        session()->flash('message', 'Customer deleted successfully.');
        // on delete refresh cache
        Cache::forget('customers_with_balances_and_latest_transactions');
        Cache::forget('customer_count');
        return $this->redirect(route('customers'));

    }

    #[Title('Customers Details')]
    public function render()
    {
        return view('livewire.v1.customer.customer-details');
    }
}
