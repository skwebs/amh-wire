<?php

namespace App\Livewire\V1\Transaction;

use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

class Transactions extends Component
{
    public $customer;
    public $transactions;
    public $sortDir = 'desc';
    public $sortField = 'datetime';
    public $filter = 'current'; // 'current'|'all'
    public $billingStartDate;
    public $billingEndDate;
    // public function setFilter($filter)
    // {
    //     $this->filter = in_array($filter, ['current', 'all']) ? $filter : 'current';
    //     // $this->fetchTransactions();
    // }

    public function setFilter($filter)
    {
        $this->filter = in_array($filter, ['current', 'all']) ? $filter : 'current';
        if ($this->filter === 'current') {
            $this->setBillingPeriod($this->customer->billing_date);
        }
        $this->fetchTransactions();
    }

    // public function calculateBalance()
    // {
    //     // Optionally compute balance dynamically if not stored in the model
    //     return $this->customer->balance ?? $this->customer->transactions()->sum('amount');
    // }

    public function calculateBalance()
    {
        // Compute balance dynamically based on filter
        $query = $this->customer->transactions();

        if ($this->filter === 'current') {
            $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
            $query->whereBetween('datetime', [
                $billingPeriod->startDate,
                $billingPeriod->endDate
            ]);
        }

        return $query->sum('amount');
    }

    public function sortBy($field)
    {
        $this->sortDir = ($field === $this->sortField) ? ($this->sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField = $field;
        $this->fetchTransactions();
    }

    public function mount(Customer $customer)
    {
        if (!$customer->exists) {
            abort(404, 'Customer not found');
        }

        $this->customer = $customer;
        $this->setBillingPeriod($customer->billing_date);
        // dd($this->currentBillingPeriod(1));
        $this->fetchTransactions();
    }

    private function setBillingPeriod(int $billingDay): void
    {
        $today = Carbon::today();
        $billingDate = $today->copy()->day($billingDay);
        $billingStartDate = $billingDate->copy()->addDay()->startOfDay();

        $this->billingStartDate = $billingStartDate->isFuture()
            ? $today->copy()->subMonth()->day($billingDay + 1)->startOfDay()
            : $billingStartDate;

        $this->billingEndDate = $billingStartDate->isFuture()
            ? $billingDate->endOfDay()
            : $today->copy()->addMonth()->day($billingDay)->endOfDay();
    }

    public function currentBillingPeriod(int $billingDay): object
    {
        $this->setBillingPeriod($billingDay);

        return (object) [
            'startDate' => $this->billingStartDate->format('Y-m-d H:i:s'),
            'endDate' => $this->billingEndDate->format('Y-m-d H:i:s'),
            'gracePeriod' => $this->billingStartDate->copy()->subDay()->addDays(20)->endOfDay()->format('Y-m-d H:i:s'),
        ];
    }

    // public function fetchTransactions()
    // {
    //     $this->transactions = $this->customer->transactions()
    //         ->orderBy($this->sortField, $this->sortDir)
    //         ->get()
    //         ->groupBy(fn($txn) => $txn->datetime->format('Y-m-d'))
    //         ->all();
    // }

    public function fetchTransactions()
    {
        $query = $this->customer->transactions()->orderBy($this->sortField, $this->sortDir);

        if ($this->filter === 'current') {
            $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
            $query->whereBetween('datetime', [
                $billingPeriod->startDate,
                $billingPeriod->endDate
            ]);
        }

        $this->transactions = $query->get()
            ->groupBy(fn($txn) => $txn->datetime->format('Y-m-d'))
            ->all();
    }

    #[Title('Transactions')]
    public function render()
    {
        return view('livewire.v1.transaction.transactions', [
            'balance' => $this->calculateBalance(),
        ]);
    }
}
