<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('homepage') }}">
            Customers List
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="flex flex-col grow overflow-y-auto overflow-x-hidden divide-y">

            @foreach ($customers as $customer)
                <a href="{{ route('customer.transactions', $customer) }}" wire:navigate>
                    <div class="w-full bg-white rounded flex h-14 hover:bg-gray-50">
                        <div class="p-[2px]">
                            <div
                                class="bg-green-50 aspect-square h-full rounded-full border flex justify-center items-center">
                                <x-icons.user-cirlce class="size-10" />
                            </div>
                        </div>
                        <div class=" flex flex-col justify-center  flex-grow px-1">
                            <div>{{ $customer->name }}</div>
                            <div class="text-xs font-semibold">
                                @if ($customer->latestTransaction)
                                    {{-- <span>{{ date('d M Y', strtotime($customer->latestTransaction->datetime)) }}</span> --}}
                                    Last txn : <span
                                        class="{{ $customer->latestTransaction?->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $customer->latestTransaction?->amount }}
                                    </span>
                                    ({{ \Carbon\Carbon::parse($customer->latestTransaction?->datetime)->diffForHumans() }})
                                @else
                                    <span class="text-gray-400">No transaction</span>
                                @endif

                            </div>
                        </div>

                        <div class="h-full flex justify-center items-center gap-x-2">
                            @php
                                $balance = abs($customer->balance);
                                $balanceClass =
                                    $customer->balance > 0
                                        ? 'text-red-600'
                                        : ($customer->balance < 0
                                            ? 'text-green-600'
                                            : '');
                            @endphp
                            <div class="{{ $balanceClass }}">
                                {{ $balance }}
                            </div>
                            <x-icons.chevron-right />
                        </div>

                    </div>
                </a>
            @endforeach
        </div>
    </main>



    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">
            <button href="{{ route('customer.create') }}" wire:navigate
                class="bg-red-700 text-white px-4 py-2 rounded flex-grow">Add New Customer</button>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
