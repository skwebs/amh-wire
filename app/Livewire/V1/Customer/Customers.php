<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

class Customers extends Component
{
    public $customers;

    // public function mount()
    // {
    //     // Load customers with their latest transaction date and balance
    //     $this->customers = Customer::with('latestTransaction')->get();
    // }

    // public function mount()
    // {
    //     // Load customers with their latest transaction date and balance, sorted by the latest transaction date
    //     $this->customers = Customer::select('customers.id', 'customers.name', 'customers.email', 'customers.phone', 'customers.address')
    //         ->leftJoin('transactions', function ($join) {
    //             $join->on('customers.id', '=', 'transactions.customer_id')
    //                 ->whereNull('transactions.deleted_at');  // Handle soft-deleted transactions
    //         })
    //         ->selectRaw('MAX(transactions.datetime) as latest_transaction_date')
    //         ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.phone', 'customers.address')
    //         ->orderBy('latest_transaction_date', 'desc')
    //         ->with('latestTransaction')  // Load the latest transaction relationship
    //         ->get();
    // }




    public function mount()
    {
        $this->customers = Cache::remember('customers_with_balances_and_latest_transactions', 600, function () {
            return Customer::select('customers.id', 'customers.name', 'customers.email', 'customers.phone', 'customers.address')
                ->leftJoin('transactions', function ($join) {
                    $join->on('customers.id', '=', 'transactions.customer_id')
                        ->whereNull('transactions.deleted_at');
                })
                ->selectRaw('MAX(transactions.datetime) as latest_transaction_date')
                ->selectRaw('SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE 0 END) as total_debit')
                ->selectRaw('SUM(CASE WHEN transactions.type = "credit" THEN transactions.amount ELSE 0 END) as total_credit')
                ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.phone', 'customers.address')
                ->orderBy('latest_transaction_date', 'desc')
                ->get();
        });
    }



    #[Title('Customer List')]
    public function render()
    {
        // dd($this->customers);
        return view('livewire.v1.customer.customers');
    }
}
