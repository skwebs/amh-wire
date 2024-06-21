<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Layout;
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
    #[Layout('layouts.wire')]
    public function render()
    {
        // dd($this->customers);
        return view('livewire.v1.customer.customers');
    }
}




// namespace App\Livewire\Customers;

// use App\Models\Customer;
// use Livewire\Attributes\On;
// use Livewire\Attributes\Title;
// use Livewire\Component;

// class CustomersList extends Component
// {
//     public $customers;
//     public $isOpen = false;

//     // #[On('open-customer-modal')]
//     public function openCustomerModal()
//     {

//         $this->isOpen = true;
//     }
//     // #[On('close-customer-modal')]
//     #[On('modal-close')]
//     public function closeCustomerModal()
//     {
//         $this->isOpen = false;
//     }

//     public function mount()
//     {
//         $this->customers = Customer::orderBy('id', 'desc')->get();
//     }

//     #[Title('Customers List')]
//     #[On('render-customer-list')]
//     public function render()
//     {
//         $this->customers = Customer::orderBy('id', 'desc')->get();
//         return view('livewire.customers.customers-list');
//     }


//     public function loadCustomers()
//     {
//         $this->customers = Customer::with(['transactions' => function ($query) {
//             $query->select('id', 'customer_uuid', 'amount', 'type', 'created_at');
//         }])
//             ->get()
//             ->map(function ($customer) {
//                 $customer->balance = $customer->transactions->reduce(function ($carry, $transaction) {
//                     return $carry + ($transaction->type === 'give' ? $transaction->amount : -$transaction->amount);
//                 }, 0);
//                 return $customer;
//             });
//     }

//     public function create()
//     {
//         $this->dispatch('open-create-customer');
//     }

//     // public function edit($id)
//     // {
//     //     $this->dispatch('editCustomer', $id);
//     // }

//     // public function delete(Customer $customer)
//     // {
//     //     $customer->delete();
//     //     session()->flash('message', 'Customer Deleted Successfully.');
//     //     $this->dispatch('customer-deleted');
//     // }
// }