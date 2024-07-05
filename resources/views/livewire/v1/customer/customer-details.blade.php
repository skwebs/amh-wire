<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customers') }}">
            Customers List
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="p-5">
            <table class="w-full">
                <tr class="border">
                    <th class="text-left p-2">Name</th>
                    <td>{{ $customer->name }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Email</th>
                    <td>{{ $customer->email }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Phone</th>
                    <td>{{ $customer->phone }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Address</th>
                    <td>{{ $customer->address }}</td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Last Txn</th>
                    <td>{{ $customer->latestTransaction->date }} |
                        {{ $customer->latestTransaction->amount }} | {{ $customer->latestTransaction->type }}
                    </td>
                </tr>
                <tr class="border">
                    <th class="text-left p-2">Balance</th>
                    <td>{{ $customer->balance }}</td>
                </tr>
            </table>


        </div>
    </main>


    <x-slot:footer>
        <div class="w-full flex justify-around p-2 border-t gap-2">

            <button href="{{ route('customer.transactions', $customer) }}" wire:navigate
                class="bg-gray-500 text-white px-4 py-1 rounded flex-grow">Go Back</button>
            <button href="{{ route('customer.update', $customer) }}" wire:navigate
                class="bg-blue-700 text-white px-4 py-1 rounded flex-grow">Update</button>

        </div>
    </x-slot:footer>

</x-wrapper-layout>
