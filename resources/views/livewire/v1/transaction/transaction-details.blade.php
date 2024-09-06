<x-wrapper-layout class=" bg-blue-50">

    <x-slot:header>
        <x-header-all class="{{ $transaction->type == 'credit' ? ' bg-green-700 ' : ' bg-red-700  ' }}"
            href="{{ route('customer.transactions', $customer) }}">
            Transaction Details
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow  overflow-y-auto {{ $transaction->type == 'debit' ? 'bg-red-50/20' : 'bg-green-50/20' }}">

        <div class="p-5">
            <table class="w-full">
                <tr class="border">
                    <th class="text-left p-2">Txn Id</th>
                    <td>:</td>
                    <td>{{ $transaction->id }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Txn Amount</th>
                    <td>:</td>
                    <td>{{ $transaction->amount }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Txn Type</th>
                    <td>:</td>
                    <td
                        class="capitalize font-semibold {{ $transaction->type == 'debit' ? 'text-red-600' : 'text-green-600' }} ">
                        {{ $transaction->type }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Txn Date</th>
                    <td>:</td>
                    <td>
                        <div class=" py-1">
                            <span class="text-nowrap">
                                {{ date('d M Y-H:i', strtotime($transaction->datetime)) }}
                            </span>
                            <span class="text-xs font-semibold text-nowrap">
                                ({{ \Carbon\Carbon::parse($transaction->datetime)->diffForHumans() }})</span>
                        </div>
                    </td>
                </tr>
                <tr class="border">
                    <th class="text-left text-nowrap p-2">Txn Remarks</th>
                    <td>:</td>
                    <td>{{ $transaction->particulars }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Created At</th>
                    <td>:</td>
                    <td>
                        <div class=" py-1">
                            <span class="text-nowrap">
                                {{ date('d M Y-H:i', strtotime($transaction->created_at)) }}
                            </span>
                            <span class="text-xs font-semibold text-nowrap">
                                ({{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }})</span>
                        </div>
                    </td>
                </tr>

            </table>
            <div class="w-full flex justify-around p-4 border-t gap-4">
                <button
                    href="{{ route('customer.transaction.update', ['customer' => $customer, 'transaction' => $transaction]) }}"
                    wire:navigate
                    class=" w-full
                bg-red-700 hover:bg-red-800 text-white rounded-md px-3 py-2 font-semibold">Delete</button>

                <button
                    href="{{ route('customer.transaction.update', ['customer' => $customer, 'transaction' => $transaction]) }}"
                    wire:navigate
                    class=" w-full
                bg-blue-700 hover:bg-blue-800 text-white rounded-md px-3 py-2 font-semibold">Edit</button>
            </div>

        </div>


    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">

            <a href="{{ route('customer.transactions', $customer) }}" wire:navigate
                class="text-center w-full inline-block bg-gray-600 hover:bg-gray-700 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
