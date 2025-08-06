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

    public function setFilter($filter)
    {
        $this->filter = in_array($filter, ['current', 'all']) ? $filter : 'current';
        if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
            $this->setBillingPeriod($this->customer->billing_date);
        }
        $this->fetchTransactions();
    }

    public function calculateBalance()
    {
        $query = $this->customer->transactions()->select('type', 'amount', 'datetime');
        if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
            $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
            if ($billingPeriod->startDate && $billingPeriod->endDate) {
                $query->whereBetween('datetime', [
                    $billingPeriod->startDate,
                    $billingPeriod->endDate
                ]);
            } else {
                return 0;
            }
        }

        return $query->get()->sum(function ($transaction) {
            return $transaction->type === 'debit' ? $transaction->amount : -$transaction->amount;
        });
    }

    public function currentExpenses()
    {
        if ($this->customer->type !== 'credit_card') {
            return 0;
        }

        $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
        if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
            return 0;
        }

        return $this->customer->transactions()
            ->select('type', 'amount', 'datetime')
            ->where('type', 'debit')
            ->whereBetween('datetime', [
                $billingPeriod->startDate,
                $billingPeriod->endDate
            ])
            ->sum('amount');
    }

    public function previousExpenses()
    {
        if ($this->customer->type !== 'credit_card') {
            return 0;
        }

        $billingPeriod = $this->previousBillingPeriod($this->customer->billing_date);
        if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
            return 0;
        }

        return $this->customer->transactions()
            ->select('type', 'amount', 'datetime')
            ->where('type', 'debit')
            ->whereBetween('datetime', [
                $billingPeriod->startDate,
                $billingPeriod->endDate
            ])
            ->sum('amount');
    }

    public function currentPayments()
    {
        if ($this->customer->type !== 'credit_card') {
            return 0;
        }

        $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
        if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
            return 0;
        }

        return $this->customer->transactions()
            ->select('type', 'amount', 'datetime')
            ->where('type', 'credit')
            ->whereBetween('datetime', [
                $billingPeriod->startDate,
                $billingPeriod->endDate
            ])
            ->sum('amount');
    }

    public function sortBy($field)
    {
        $allowedFields = ['id', 'amount', 'type', 'datetime'];
        $this->sortField = in_array($field, $allowedFields) ? $field : 'datetime';
        $this->sortDir = ($field === $this->sortField) ? ($this->sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->fetchTransactions();
    }

    public function mount(Customer $customer)
    {
        if (!$customer->exists) {
            abort(404, 'Customer not found');
        }

        if ($customer->type === 'credit_card' && $customer->billing_date === null) {
            return redirect()->route('customer.update', [$customer, 'm' => 'Please set Billing Date for this Credit Card']);
        }

        $this->customer = $customer;

        if ($this->customer->type === 'credit_card' && $this->filter === 'current') {
            $this->setBillingPeriod($customer->billing_date);
        }

        $this->fetchTransactions();
    }

    private function setBillingPeriod(int $billingDay): void
    {
        if ($this->customer->type !== 'credit_card') {
            return;
        }

        if ($billingDay < 1 || $billingDay > 28) {
            abort(400, 'Invalid billing day');
        }

        $today = Carbon::today();
        $billingDate = $today->copy()->setDay($billingDay);
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
        if ($this->customer->type !== 'credit_card') {
            return (object) [
                'startDate' => null,
                'endDate' => null,
                'gracePeriod' => null,
            ];
        }

        $this->setBillingPeriod($billingDay);

        return (object) [
            'startDate' => $this->billingStartDate ? $this->billingStartDate->format('Y-m-d H:i:s') : null,
            'endDate' => $this->billingEndDate ? $this->billingEndDate->format('Y-m-d H:i:s') : null,
            'gracePeriod' => $this->billingStartDate ? $this->billingStartDate->copy()->subDay()->addDays(20)->endOfDay()->format('Y-m-d H:i:s') : null,
        ];
    }

    public function previousBillingPeriod(int $billingDay): object
    {
        if ($this->customer->type !== 'credit_card') {
            return (object) [
                'startDate' => null,
                'endDate' => null,
            ];
        }

        if ($billingDay < 1 || $billingDay > 28) {
            abort(400, 'Invalid billing day');
        }

        $today = Carbon::today();
        $currentBillingDate = $today->copy()->setDay($billingDay);
        $currentStartDate = $currentBillingDate->copy()->addDay()->startOfDay();

        // Determine the current billing period's start and end
        $currentPeriodStart = $currentStartDate->isFuture()
            ? $today->copy()->subMonth()->day($billingDay + 1)->startOfDay()
            : $currentStartDate;
        $currentPeriodEnd = $currentStartDate->isFuture()
            ? $currentBillingDate->endOfDay()
            : $today->copy()->addMonth()->day($billingDay)->endOfDay();

        // Previous billing period is one month before the current period
        $previousPeriodStart = $currentPeriodStart->copy()->subMonth();
        $previousPeriodEnd = $currentPeriodEnd->copy()->subMonth();

        return (object) [
            'startDate' => $previousPeriodStart->format('Y-m-d H:i:s'),
            'endDate' => $previousPeriodEnd->format('Y-m-d H:i:s'),
        ];
    }

    public function fetchTransactions()
    {
        $query = $this->customer->transactions()->select('id', 'customer_id', 'particulars', 'amount', 'type', 'datetime')
            ->orderBy($this->sortField, $this->sortDir);

        if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
            $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
            if ($billingPeriod->startDate && $billingPeriod->endDate) {
                $query->whereBetween('datetime', [
                    $billingPeriod->startDate,
                    $billingPeriod->endDate
                ]);
            } else {
                return [];
            }
        }

        $this->transactions = $query->get()->groupBy(fn($txn) => $txn->datetime->format('Y-m-d'))->all();
    }

    #[Title('Transactions')]
    public function render()
    {
        return view('livewire.v1.transaction.transactions', [
            'balance' => $this->calculateBalance(),
            'currentExpenses' => $this->currentExpenses(),
            'previousExpenses' => $this->previousExpenses(),
            'currentPayments' => $this->currentPayments(),
        ]);
    }
}

// namespace App\Livewire\V1\Transaction;

// use App\Models\Customer;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\Cache;
// use Livewire\Attributes\Title;
// use Livewire\Component;

// class Transactions extends Component
// {
//     public $customer;
//     public $transactions;
//     public $sortDir = 'desc';
//     public $sortField = 'datetime';
//     public $filter = 'current'; // 'current'|'all'
//     public $billingStartDate;
//     public $billingEndDate;

//     public function setFilter($filter)
//     {
//         $this->filter = in_array($filter, ['current', 'all']) ? $filter : 'current';
//         if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
//             $this->setBillingPeriod($this->customer->billing_date);
//         }
//         $this->fetchTransactions();
//     }

//     public function calculateBalance()
//     {
//         $cacheKey = "balance_{$this->customer->id}_{$this->filter}";
//         return Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             $query = $this->customer->transactions()->select('type', 'amount', 'datetime');
//             if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
//                 $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
//                 if ($billingPeriod->startDate && $billingPeriod->endDate) {
//                     $query->whereBetween('datetime', [
//                         $billingPeriod->startDate,
//                         $billingPeriod->endDate
//                     ]);
//                 } else {
//                     return 0;
//                 }
//             }

//             return $query->get()->sum(function ($transaction) {
//                 return $transaction->type === 'debit' ? $transaction->amount : -$transaction->amount;
//             });
//         });
//     }

//     public function currentExpenses()
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return 0;
//         }

//         $cacheKey = "current_expenses_{$this->customer->id}";
//         return Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
//             if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
//                 return 0;
//             }

//             return $this->customer->transactions()
//                 ->select('type', 'amount', 'datetime')
//                 ->where('type', 'debit')
//                 ->whereBetween('datetime', [
//                     $billingPeriod->startDate,
//                     $billingPeriod->endDate
//                 ])
//                 ->sum('amount');
//         });
//     }

//     public function previousExpenses()
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return 0;
//         }

//         $cacheKey = "previous_expenses_{$this->customer->id}";
//         return Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             $billingPeriod = $this->previousBillingPeriod($this->customer->billing_date);
//             if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
//                 return 0;
//             }

//             return $this->customer->transactions()
//                 ->select('type', 'amount', 'datetime')
//                 ->where('type', 'debit')
//                 ->whereBetween('datetime', [
//                     $billingPeriod->startDate,
//                     $billingPeriod->endDate
//                 ])
//                 ->sum('amount');
//         });
//     }

//     public function currentPayments()
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return 0;
//         }

//         $cacheKey = "current_payments_{$this->customer->id}";
//         return Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
//             if (!$billingPeriod->startDate || !$billingPeriod->endDate) {
//                 return 0;
//             }

//             return $this->customer->transactions()
//                 ->select('type', 'amount', 'datetime')
//                 ->where('type', 'credit')
//                 ->whereBetween('datetime', [
//                     $billingPeriod->startDate,
//                     $billingPeriod->endDate
//                 ])
//                 ->sum('amount');
//         });
//     }



//     public function sortBy($field)
//     {
//         $allowedFields = ['id', 'amount', 'type', 'datetime'];
//         $this->sortField = in_array($field, $allowedFields) ? $field : 'datetime';
//         $this->sortDir = ($field === $this->sortField) ? ($this->sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
//         $this->fetchTransactions();
//     }

//     public function mount(Customer $customer)
//     {
//         if (!$customer->exists) {
//             abort(404, 'Customer not found');
//         }

//         if ($customer->type === 'credit_card' && $customer->billing_date === null) {
//             return redirect()->route('customer.update', [$customer, 'm' => 'Please set Billing Date for this Credit Card']);
//         }

//         $this->customer = $customer;

//         if ($this->customer->type === 'credit_card' && $this->filter === 'current') {
//             $this->setBillingPeriod($customer->billing_date);
//         }

//         $this->fetchTransactions();
//     }

//     private function setBillingPeriod(int $billingDay): void
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return;
//         }

//         if ($billingDay < 1 || $billingDay > 28) {
//             abort(400, 'Invalid billing day');
//         }

//         $today = Carbon::today();
//         $billingDate = $today->copy()->setDay($billingDay);
//         $billingStartDate = $billingDate->copy()->addDay()->startOfDay();

//         $this->billingStartDate = $billingStartDate->isFuture()
//             ? $today->copy()->subMonth()->day($billingDay + 1)->startOfDay()
//             : $billingStartDate;

//         $this->billingEndDate = $billingStartDate->isFuture()
//             ? $billingDate->endOfDay()
//             : $today->copy()->addMonth()->day($billingDay)->endOfDay();
//     }

//     public function currentBillingPeriod(int $billingDay): object
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return (object) [
//                 'startDate' => null,
//                 'endDate' => null,
//                 'gracePeriod' => null,
//             ];
//         }

//         $this->setBillingPeriod($billingDay);

//         return (object) [
//             'startDate' => $this->billingStartDate ? $this->billingStartDate->format('Y-m-d H:i:s') : null,
//             'endDate' => $this->billingEndDate ? $this->billingEndDate->format('Y-m-d H:i:s') : null,
//             'gracePeriod' => $this->billingStartDate ? $this->billingStartDate->copy()->subDay()->addDays(20)->endOfDay()->format('Y-m-d H:i:s') : null,
//         ];
//     }

//     public function previousBillingPeriod(int $billingDay): object
//     {
//         if ($this->customer->type !== 'credit_card') {
//             return (object) [
//                 'startDate' => null,
//                 'endDate' => null,
//             ];
//         }

//         if ($billingDay < 1 || $billingDay > 28) {
//             abort(400, 'Invalid billing day');
//         }

//         $today = Carbon::today();
//         $currentBillingDate = $today->copy()->setDay($billingDay);
//         $currentStartDate = $currentBillingDate->copy()->addDay()->startOfDay();

//         // Determine the current billing period's start and end
//         $currentPeriodStart = $currentStartDate->isFuture()
//             ? $today->copy()->subMonth()->day($billingDay + 1)->startOfDay()
//             : $currentStartDate;
//         $currentPeriodEnd = $currentStartDate->isFuture()
//             ? $currentBillingDate->endOfDay()
//             : $today->copy()->addMonth()->day($billingDay)->endOfDay();

//         // Previous billing period is one month before the current period
//         $previousPeriodStart = $currentPeriodStart->copy()->subMonth();
//         $previousPeriodEnd = $currentPeriodEnd->copy()->subMonth();

//         return (object) [
//             'startDate' => $previousPeriodStart->format('Y-m-d H:i:s'),
//             'endDate' => $previousPeriodEnd->format('Y-m-d H:i:s'),
//         ];
//     }

//     public function fetchTransactions()
//     {
//         $cacheKey = "transactions_{$this->customer->id}_{$this->filter}_{$this->sortField}_{$this->sortDir}";
//         $this->transactions = Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             $query = $this->customer->transactions()->select('id', 'customer_id', 'particulars', 'amount', 'type', 'datetime')
//                 ->orderBy($this->sortField, $this->sortDir);

//             if ($this->filter === 'current' && $this->customer->type === 'credit_card') {
//                 $billingPeriod = $this->currentBillingPeriod($this->customer->billing_date);
//                 if ($billingPeriod->startDate && $billingPeriod->endDate) {
//                     $query->whereBetween('datetime', [
//                         $billingPeriod->startDate,
//                         $billingPeriod->endDate
//                     ]);
//                 } else {
//                     return [];
//                 }
//             }

//             return $query->get()->groupBy(fn($txn) => $txn->datetime->format('Y-m-d'))->all();
//         });
//     }

//     #[Title('Transactions')]
//     public function render()
//     {
//         return view('livewire.v1.transaction.transactions', [
//             'balance' => $this->calculateBalance(),
//             'currentExpenses' => $this->currentExpenses(),
//             'previousExpenses' => $this->previousExpenses(),
//             'currentPayments' => $this->currentPayments(),
//         ]);
//     }
// }
