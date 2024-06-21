<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateCustomer extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $type;



    public function addCustomer()
    {
        $this->validate([
            'name' => 'required|min:0',
            'email' => 'nullable|email',
            'phone' => 'nullable|size:10|string|max:255',
            'address' => 'nullable|string|min:5|max:255',
        ]);

        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        // Optionally, clear the form fields
        $this->reset();

        // Emit an event to notify success
        // $this->dispatch('customer-created');

        session()->flash('message', 'Customer added successfully.');

        return $this->redirect(route('customers'), navigate: true);
    }


    #[Layout('layouts.wire')]
    public function render()
    {
        return view('livewire.v1.customer.create-customer');
    }
}
