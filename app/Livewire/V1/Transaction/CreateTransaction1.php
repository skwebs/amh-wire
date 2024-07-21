<?php

// namespace App\Livewire\V1\Transaction;

// use App\Models\Customer;
// use Livewire\Component;

// class CreateTransaction extends Component
// {

//     public function mount(Customer $customer)
//     {
//         $type = request('type');
//         $customer->transactions->create([]);

//     }
//     public function render()
//     {
//         return view('livewire.v1.transaction.create-transaction');
//     }
// }

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateTransaction extends Component
{
    public $customer;
    public $type;
    public $amount;
    public $date;
    public $particulars;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;

        $this->type = request('type') === 'd' ? 'debit' : (request('type') === 'c' ? 'credit' : null); // 'debit' or 'credit'
        $this->date = now()->format('Y-m-d'); // default to current date if not provided by the user
    }

    public function saveTransaction()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'particulars' => 'nullable|string|max:255',
        ]);

        $this->customer->transactions()->create([
            'amount' => $this->amount,
            'date' => $this->date,
            'particulars' => $this->particulars,
            'type' => $this->type,
        ]);

        session()->flash('message', 'Transaction created successfully.');
        return $this->redirect(route('customer.transactions', $this->customer->id), navigate: true);
    }

    // #[Layout('layouts.wire')]
    public function render()
    {
        return $this->type === 'debit' ? view('livewire.v1.transaction.create-debit-transaction') : view('livewire.v1.transaction.create-credit-transaction');
    }
}
