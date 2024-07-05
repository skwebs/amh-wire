<?php

namespace App\Livewire\V1\Transaction;

use Livewire\Attributes\Layout;
use Livewire\Component;

class TransactionDetails extends Component
{

    // #[Layout('layouts.wire')]
    public function render()
    {
        return view('livewire.v1.transaction.transaction-details');
    }
}
