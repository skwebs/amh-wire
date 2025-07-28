<?php

namespace App\Livewire\V1;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


enum AccountType: string
{
    case CREDIT_CARD = 'credit_card';
    case CASH = 'cash';
    case BANK = 'bank';
    case OTHER = 'other';
    case INCOME = 'income';
    case EXPENSE = 'expense';
}

class Homepage extends Component
{
    public $user;
    public $transactions;
    public $creditCardsExpenses;
    public $cashBalance;
    public $banksBalance;
    public $otherBalance;

    /**
     * Log out the authenticated user and redirect to login.
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        $this->redirectRoute('login');
    }

    /**
     * Initialize component data.
     */
    public function mount()
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        $this->user = Auth::user();
        $this->creditCardsExpenses = $this->balance(AccountType::CREDIT_CARD->value);
        $this->cashBalance = $this->balance(AccountType::CASH->value);
        $this->banksBalance = $this->balance(AccountType::BANK->value);
        $this->otherBalance = $this->balance(AccountType::OTHER->value);
        $this->transactions = Transaction::whereHas('customer', function ($query) {
            $query->where('user_id', $this->user->id);
        })->with('customer')->orderByDesc('datetime')->take(5)->get();
    }

    /**
     * Calculate the balance for a given account type.
     *
     * @param string $accountType The type of account (e.g., 'credit_card', 'cash', 'bank', 'other')
     * @return float The net balance (credits - debits)
     */
    public function balance(string $accountType)
    {
        try {
            $accountTypeEnum = AccountType::from($accountType);
        } catch (\InvalidArgumentException $e) {
            Log::warning("Invalid account type provided: {$accountType}");
            return 0;
        }

        $cacheKey = "balance_{$this->user->id}_{$accountTypeEnum->value}";

        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($accountTypeEnum) {
            $customerIds = Customer::where('user_id', $this->user->id)
                ->where('type', $accountTypeEnum->value)
                ->pluck('id');

            $totalCredits = Transaction::whereIn('customer_id', $customerIds)
                ->where('type', 'credit')
                ->sum('amount');

            $totalDebits = Transaction::whereIn('customer_id', $customerIds)
                ->where('type', 'debit')
                ->sum('amount');

            return $totalCredits - $totalDebits;
        });
    }

    #[Title('Home page')]
    public function render()
    {
        return view('livewire.v1.homepage');
    }
}
