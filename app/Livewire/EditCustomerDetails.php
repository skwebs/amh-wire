<?php

// namespace App\Livewire;

// use Livewire\Component;

// class EditCustomerDetails extends Component
// {
//     public function render()
//     {
//         return view('livewire.edit-customer-details');
//     }
// }



// app/Http/Livewire/EditCustomerDetails.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class EditCustomerDetails extends Component
{
    public $customerId;
    public $name;
    public $email;
    public $phone;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:15',
    ];

    public function mount($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->customerId = $customer->id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
    }

    public function save()
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customerId);
        $customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'Customer updated successfully.');
    }

    public function render()
    {
        return view('livewire.edit-customer-details');
    }
}
