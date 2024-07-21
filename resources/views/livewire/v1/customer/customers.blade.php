<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all>
            Customers List
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="flex flex-col gap-1 grow overflow-y-auto overflow-x-hidden">

            @foreach ($customers as $customer)
                <a href="{{ route('customer.transactions', $customer) }}" wire:navigate>
                    <div class="w-full bg-white rounded flex h-14">
                        <div class="p-[2px]">
                            <div
                                class="bg-green-50 aspect-square h-full rounded-full border flex justify-center items-center">
                                photo
                            </div>
                        </div>
                        <div class=" flex flex-col justify-center  flex-grow px-1">
                            <div>{{ $customer->name }}</div>
                            <div class="text-xs">{{ $customer->created_at }}</div>
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
        <div class="w-full flex justify-around p-2 border-t gap-2">

            <button href="{{ route('customer.create', ['customer' => $customer, 'type' => 'd']) }}" wire:navigate
                class="bg-red-700 text-white px-4 py-1 rounded flex-grow">Add New Customer</button>

        </div>
    </x-slot:footer>

</x-wrapper-layout>
