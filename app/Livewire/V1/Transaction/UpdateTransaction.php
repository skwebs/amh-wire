<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;
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
    }

    public function updateTransaction()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'datetime' => 'required|date_format:Y-m-d\TH:i|before_or_equal:now',
            'particulars' => 'nullable|string|max:255',
        ]);

        $this->transaction->update([
            'amount' => $this->amount,
            'datetime' => $this->datetime,
            'particulars' => $this->particulars,
            'type' => $this->type,
        ]);

        session()->flash('message', 'Transaction updated successfully.');

        Cache::forget('customers_with_balances_and_latest_transactions');
        Cache::forget('customer_count');

        return $this->redirect(route('customer.transactions', $this->customer->id), navigate: true);
    }

    #[Title('Update Transaction')]
    public function render()
    {
        return view('livewire.v1.transaction.update-transaction');
    }
}
