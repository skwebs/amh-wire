<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateCustomer extends Component
{
    public string $name = '';
    // public string $email = '';
    // public string $phone = '';
    // public string $address = '';
    public string $type = '';
    public string $category = '';

    public ?int $billing_date = null;

    /**
     * Creates a new customer and redirects to the customers page.
     *
     * @throws \Illuminate\Validation\ValidationException if validation fails
     */
    public function addCustomer(): void
    {
        $this->validate([
            'name' => 'required|min:0',
            'type' => 'required|in:cash,bank,credit_card,income,expense,other',
            'billing_date' => 'nullable|integer|min:1|max:28|required_if:type,credit_card',
        ], [
            'billing_date.required_if' => 'The billing date field is required when the type is Credit Card.',
        ]);

        $userId = auth()->guard()->user()->id;

        Customer::create([
            'user_id' => $userId,
            'name' => $this->name,
            'type' => $this->type,
            'billing_date' => $this->billing_date,
        ]);

        // Reset form fields
        $this->reset();

        $this->dispatch('customer-created');

        session()->flash('message', 'Customer added successfully.');

        $this->redirect(route('customers'), navigate: true);
    }

    #[Title('Create Customer')]
    public function render()
    {
        return view('livewire.v1.customer.create-customer');
    }
}
