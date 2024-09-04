<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customer.transactions', $customer->id) }}">
            <a wire:navigate href="{{ route('customer.details', $customer) }}" class="flex justify-center items-center ">
                <div class="aspect-square h-full">
                    <x-icons.user-cirlce />
                </div>
                <div>
                    <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                    <div class="text-nowrap font-bold text-sm text-center">
                        Customer Details
                    </div>
                </div>
            </a>

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
                    <td
                        class="{{ $customer->balance > 0 ? 'text-red-600' : ($customer->balance < 0 ? 'text-green-600' : '') }}">
                        {{ abs($customer->balance) }}
                        {{ $customer->balance > 0 ? 'Dr' : ($customer->balance < 0 ? 'Cr' : '') }}</td>
                </tr>
            </table>
            <div class="mt-5">
                <button href="{{ route('customer.update', $customer) }}" wire:navigate
                    class="bg-blue-700 text-white px-4 py-1 rounded w-full">Edit</button>
            </div>
            <div class="mt-5">
                @php
                    $url = route('customer.summary', [
                        'customer' => $customer,
                        'd' => strtotime($customer->created_at),
                    ]);
                    $msg = urlencode('Open link for statement: ' . $url);
                @endphp
                {{-- @dd($customer->created_at->format('d-m-Y H:i:s')); --}}
                <a class="bg-blue-700 text-white px-4 py-1 rounded w-full" href="sms:?body={{ $msg }}"
                    class="share-button sms-button">Share via
                    SMS</a>
                <a class="bg-blue-700 text-white px-4 py-1 rounded w-full"
                    href="https://api.whatsapp.com/send?text={{ $msg }}"
                    class="share-button whatsapp-button">Share via WhatsApp</a>
            </div>

        </div>
    </main>


    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">

            <button href="{{ route('customer.transactions', $customer) }}" wire:navigate
                class="bg-gray-500 text-white px-4 py-1 rounded flex-grow">Go Back</button>


        </div>
    </x-slot:footer>



</x-wrapper-layout>
