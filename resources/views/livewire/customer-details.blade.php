{{-- <div>
    <h2>{{ $customer->name }}'s Ledger</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Particulars</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr wire:click="showEntryDetails({{ $entry->id }})">
                    <td>{{ $entry->created_at->format('Y-m-d') }}</td>
                    <td>{{ $entry->particulars }}</td>
                    <td>{{ $entry->type === 'debit' ? $entry->amount : '' }}</td>
                    <td>{{ $entry->type === 'credit' ? $entry->amount : '' }}</td>
                    <td>{{ $entry->balance }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}


<div x-data="{ open: false, entry: null }">
    <h2>{{ $customer->name }}'s Ledger</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Particulars</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr @click="open = true; entry = {{ $entry->toJson() }}">
                    <td>{{ $entry->created_at->format('Y-m-d') }}</td>
                    <td>{{ $entry->particulars }}</td>
                    <td>{{ $entry->type === 'debit' ? $entry->amount : '' }}</td>
                    <td>{{ $entry->type === 'credit' ? $entry->amount : '' }}</td>
                    <td>{{ $entry->balance }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div x-show="open" class="modal">
        <div class="modal-content">
            <h3>Entry Details</h3>
            <p>Date: <span x-text="entry.created_at"></span></p>
            <p>Particulars: <span x-text="entry.particulars"></span></p>
            <p>Amount: <span x-text="entry.amount"></span></p>
            <p>Type: <span x-text="entry.type"></span></p>
            <button @click="open = false">Close</button>
        </div>
    </div>
</div>
