<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UpdateTransaction extends Component
{

    public $customer;
    public $transaction;
    public $type;
    public $amount;
    public $date;
    public $particulars;

    public function mount(Customer $customer, Transaction $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        $this->type = $transaction->type;
        $this->amount = $transaction->amount;
        $this->date = $transaction->date;
        $this->particulars = $transaction->particulars;
        // $this->type = request('type') === 'd' ? 'debit' : (request('type') === 'c' ? 'credit' : null); // 'debit' or 'credit'
        // $this->date = now()->format('Y-m-d'); // default to current date if not provided by the user
    }
    public function updateTransaction()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'particulars' => 'nullable|string|max:255',
        ]);

        $this->transaction->update([
            'amount' => $this->amount,
            'date' => $this->date,
            'particulars' => $this->particulars,
            'type' => $this->type,
        ]);

        session()->flash('message', 'Transaction updated successfully.');
        // return $this->redirect(route('customer.transaction.details', ['customer' => $this->customer, 'transaction' => $this->transaction]), navigate: true);
        return $this->redirect(route('customer.transactions', $this->customer->id), navigate: true);
    }
    // #[Layout('layouts.wire')]
    public function render()
    {
        // dd($this->transaction);
        return view('livewire.v1.transaction.update-transaction');
    }
}
