<x-wrapper-layout class="bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('homepage') }}">
            {{ auth()->user()->name }} | Accounts
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow overflow-y-auto bg-blue-50">
        <div class="flex grow flex-col divide-y overflow-y-auto overflow-x-hidden">

            @foreach ($customers as $customer)
                <a href="{{ route('customer.transactions', $customer) }}" wire:navigate>
                    <div class="flex h-14 w-full rounded bg-white hover:bg-gray-50">
                        <div class="p-[2px]">
                            <div
                                class="flex aspect-square h-full items-center justify-center rounded-full border bg-green-50">
                                <x-icons.user-cirlce class="size-10" />
                            </div>
                        </div>
                        <div class="flex flex-grow flex-col justify-center px-1">
                            <div>{{ $customer->name }} ({{ ucwords(str_replace('_', ' ', $customer->type)) }})</div>

                            <div class="text-xs font-semibold">
                                @if ($customer->latestTransaction)
                                    Last txn : <span @class([
                                        'text-green-600' => $customer->latestTransaction?->type === 'credit',
                                        'text-red-600' => $customer->latestTransaction?->type === 'debit',
                                    ])>
                                        {{ $customer->latestTransaction?->amount }}
                                    </span>
                                    ({{ \Carbon\Carbon::parse($customer->latestTransaction?->datetime)->diffForHumans() }})
                                @else
                                    <span class="text-gray-400">No transaction</span>
                                @endif

                            </div>
                        </div>

                        <div class="flex h-full items-center justify-center gap-x-2">
                            @php
                                $balance = abs($customer->balance);
                            @endphp
                            <div @class([
                                'text-red-600' => $customer->balance > 0,
                                'text-green-600' => $customer->balance < 0,
                            ])>
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
        <div class="flex w-full justify-around gap-4 border-t p-4">
            <button href="{{ route('customer.create') }}" wire:navigate
                class="flex-grow rounded bg-red-700 px-4 py-2 text-white">Add New Customer</button>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
