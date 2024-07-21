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
                    <td>{{ $transaction->date }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Created At</th>
                    <td>:</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>

            </table>
            <div class="w-full flex justify-around p-2 border-t gap-2">
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
        <div class="w-full flex justify-around p-2 border-t gap-2">

            <a href="{{ route('customer.transactions', $customer) }}"
                class="text-center w-full inline-block bg-gray-600 hover:bg-gray-700 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
