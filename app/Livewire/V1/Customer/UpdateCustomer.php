<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

class UpdateCustomer extends Component
{
    public $customer;

    public $user_id;
    public $name;

    public $email;

    public $phone;

    public $address;

    public $type;

    /**
     * Initializes the component with a customer object.
     *
     * @param  Customer  $customer  The customer object to initialize with.
     */
    public function mount(Customer $customer)
    {

        // dd($customer);

        $this->customer = $customer;
        $this->user_id = auth()->guard()->user()->id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->type = $customer->type;
    }

    public function updateCustomer()
    {
        $this->validate([
            'name' => 'required|min:0',
            'email' => 'nullable|email',
            'phone' => 'nullable|size:10|string|max:255',
            'address' => 'nullable|string|min:5|max:255',
            'type' => 'required|in:cash,bank,credit_card,income,expense,other',
        ]);

        $this->customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'type' => $this->type,
        ]);

        // Optionally, clear the form fields
        // $this->reset();

        // Dispatch an event to notify success
        // $this->dispatch('customer-created');

        Cache::forget('customers_with_balances_and_latest_transactions');
        Cache::forget('customer_count');

        session()->flash('message', 'Customer updated successfully.');

        // dd($this->customer);
        return $this->redirect(route('customer.details', $this->customer->id), navigate: true);

        // href="{{ route('customer.transaction.details', ['customer' => $customer->id, 'transaction' => $transaction]) }}"
    }

    #[Title('Update Customer')]
    public function render()
    {
        // dd($this->customer);
        return view('livewire.v1.customer.update-customer');
    }
}
