<?php

namespace App\Livewire\V1;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Livewire\Component;

class Homepage extends Component
{
    // user details
    public $user;
    public $transactions;

    // credit cards expenses
    public $creditCardsExpenses;

    // cash balance
    public $cashBalance;
    //  banks balance
    public $banksBalance;
    // other transactions
    public $otherBalance; // Uncomment if you have other types of transactions

    public $balance;

    public $customerNumber;

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->creditCardsExpenses = $this->balance('credit_card');

        $this->cashBalance = $this->balance('cash');
        $this->banksBalance = $this->balance('bank');
        $this->otherBalance = $this->balance('other'); // Uncomment if you have other types of transactions







        // Calculate debits and credits directly in the database
        $debits = Transaction::where('type', 'debit')->sum('amount');
        $credits = Transaction::where('type', 'credit')->sum('amount');

        // Calculate balance
        $this->balance = $debits - $credits;

        // Retrieve and cache customer count
        $this->customerNumber = Cache::remember('customer_count', 600, function () {
            return Customer::count();
        });

        // Optionally, limit the number of transactions retrieved if only a subset is needed
        $this->transactions = Transaction::latest()->take(100)->get(); // Example: Get the latest 100 transactions
    }



    public function balance($accountType)
    {
        // Fetch customers of the specified type for the current user
        $customers = Customer::where('user_id', $this->user->id)
            ->where('type', $accountType)
            ->with('transactions')
            ->get();

        // Calculate totals
        $totalCredits = $customers->flatMap->transactions
            ->where('type', 'credit')
            ->sum('amount');

        $totalDebits = $customers->flatMap->transactions
            ->where('type', 'debit')
            ->sum('amount');

        return $totalCredits - $totalDebits;
    }

    #[Title('Home page')]
    public function render()
    {
        // dd($this->balance);
        return view('livewire.v1.homepage');
    }
}
