<div class="">
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

        <div class="w-full flex justify-around p-2 gap-2 my-5">

            <a href="{{ route('customer.update', $customer) }}" wire:navigate
                class="text-center w-full inline-block bg-green-700 text-white px-4 py-1 rounded flex-grow">Update</a>
            <a href="{{ route('customer.transactions', $customer) }}"
                class="text-center w-full inline-block bg-gray-700 hover:bg-gray-800 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>
        </div>
    </div>
</div>
