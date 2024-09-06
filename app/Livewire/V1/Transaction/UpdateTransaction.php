<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UpdateTransaction extends Component
{

    public $customer;
    public $transaction;
    public $type;
    public $amount;
    public $datetime;
    public $particulars;

    public function mount(Customer $customer, Transaction $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        $this->type = $transaction->type;
        $this->amount = $transaction->amount;
        $this->datetime = date('Y-m-d\TH:i', strtotime($transaction->datetime));
        $this->particulars = $transaction->particulars;

        // dd($this->datetime);
        // $this->type = request('type') === 'd' ? 'debit' : (request('type') === 'c' ? 'credit' : null); // 'debit' or 'credit'
        // $this->datetime = now()->format('Y-m-d'); // default to current datetime if not provided by the user
    }
    public function updateTransaction()
    {

        // dd($this->datetime);
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'datetime' => 'required|date_format:Y-m-d\TH:i',
            'particulars' => 'nullable|string|max:255',
        ]);

        $this->transaction->update([
            'amount' => $this->amount,
            'datetime' => $this->datetime,
            'particulars' => $this->particulars,
            'type' => $this->type,
        ]);

        session()->flash('message', 'Transaction updated successfully.');
        // return $this->redirect(route('customer.transaction.details', ['customer' => $this->customer, 'transaction' => $this->transaction]), navigate: true);
        return $this->redirect(route('customer.transactions', $this->customer->id), navigate: true);
    }
    // #[Layout('layouts.wire')]
    #[Title('Update Transaction')]
    public function render()
    {
        return view('livewire.v1.transaction.update-transaction');
    }
}
