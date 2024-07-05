<?php

namespace App\Livewire\V1\Transaction;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UpdateTransaction extends Component
{

    // #[Layout('layouts.wire')]
    public function render()
    {
        return view('livewire.v1.transaction.update-transaction');
    }
}
