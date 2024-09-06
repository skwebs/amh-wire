<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TransactionDetails extends Component
{
    public $customer;
    public $transaction;



    public function mount(Customer $customer, Transaction $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        // $this->transactions = $customer->transactions()->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        // $this->transactions = $customer->transactions()->get();
    }

    public function delete(){

        $this->transaction->delete();
        session()->flash('message', 'Transaction deleted successfully.');
        return $this->redirect(route('customer.transactions', $this->customer->id), navigate: true);
    }

    // #[Layout('layouts.wire')]
    #[Title('Transaction Details')]
    public function render()
    {
        return view('livewire.v1.transaction.transaction-details');
    }
}
