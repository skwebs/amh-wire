<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
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
        $this->type = request('type') === 'd' ? 'debit' : (request('type') === 'c' ? 'credit' : null);
        $this->date = now()->format('Y-m-d');
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

    public function render()
    {
        return view('livewire.v1.transaction.create-transaction', [
            'transactionType' => $this->type,
            'customer' => $this->customer,
        ]);
    }
}