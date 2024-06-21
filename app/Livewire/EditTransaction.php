<?php

namespace App\Livewire;

use Livewire\Component;

class EditTransaction extends Component
{
    public function render()
    {
        return view('livewire.edit-transaction');
    }
}




// namespace App\Livewire;

// use Livewire\Component;
// // use App\Models\Transaction;

// class EditTransaction extends Component
// {
//     public $transactionId;
//     public $amount;
//     public $type;
//     public $date;

//     protected $rules = [
//         'amount' => 'required|numeric',
//         'type' => 'required|string|in:debit,credit',
//         'date' => 'required|date',
//     ];

//     public function mount($transactionId)
//     {
//         $transaction = Transaction::findOrFail($transactionId);
//         $this->transactionId = $transaction->id;
//         $this->amount = $transaction->amount;
//         $this->type = $transaction->type;
//         $this->date = $transaction->date->format('Y-m-d');
//     }

//     public function save()
//     {
//         $this->validate();

//         $transaction = Transaction::findOrFail($this->transactionId);
//         $transaction->update([
//             'amount' => $this->amount,
//             'type' => $this->type,
//             'date' => $this->date,
//         ]);

//         session()->flash('message', 'Transaction updated successfully.');
//     }

//     public function render()
//     {
//         return view('livewire.edit-transaction');
//     }
// }