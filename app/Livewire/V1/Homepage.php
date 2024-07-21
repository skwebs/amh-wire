<?php

namespace App\Livewire\V1;

use App\Models\Transaction;
use Livewire\Component;

class Homepage extends Component
{
    public $transactions;
    public $balance;

    public function mount()
    {
        $this->transactions = new Transaction();
        $debits = Transaction::where('type', 'debit')->sum('amount');
        $credits = Transaction::where('type', 'credit')->sum('amount');
        $this->balance =   $debits - $credits;
    }

    public function render()
    {
        // dd($this->balance);
        return view('livewire.v1.homepage');
    }
}
