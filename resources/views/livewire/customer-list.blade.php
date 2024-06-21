<div>
    <h1>Customer Ledger</h1>
    <ul>
        @foreach ($customers as $customer)
            <li wire:click="showCustomerDetails({{ $customer->id }})">
                <div>{{ $customer->name }}</div>
                <div>Balance: {{ number_format($customer->balance, 2) }}</div>
                <div>Last Transaction: {{ optional($customer->latestJournalEntry)->created_at->diffForHumans() }}</div>
            </li>
        @endforeach
    </ul>
</div>
