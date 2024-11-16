<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateCustomer extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $type;

    /**
     * Creates a new customer and redirects to the customers page.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException if validation fails
     */
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

        // refresh token on customer create
        Cache::forget('customers_with_balances_and_latest_transactions');
        Cache::forget('customer_count');

        $this->dispatch('customer-created');

        session()->flash('message', 'Customer added successfully.');

        return $this->redirect(route('customers'), navigate: true);
    }

    // #[Layout('layouts.wire')]
    #[Title('Create Customer')]
    public function render()
    {
        return view('livewire.v1.customer.create-customer');
    }
}
