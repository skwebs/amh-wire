<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header>
        @php
            $cBal = $this->calculateBalance();
        @endphp
        <x-header-all href="{{ route('customers') }}"
            class="{{ $cBal > 0 ? 'bg-red-700' : ($cBal < 0 ? 'bg-green-700' : '') }}">
            <a wire:navigate href="{{ route('customer.details', $customer) }}" class="flex justify-center items-center ">
                <div class="aspect-square h-full">
                    <x-icons.user-cirlce />
                </div>
                <div>
                    <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                    <div class="text-nowrap font-bold text-sm text-center">
                        Bal: ₹
                        {{ number_format(abs($this->calculateBalance()), 2) }}
                        <span class="{{ $cBal > 0 ? 'text-red-200' : ($cBal < 0 ? 'text-green-300' : '') }}">
                        </span>
                    </div>
                </div>
            </a>
        </x-header-all>
    </x-slot:header>

    <main>
        <div class="overflow-x-auto w-full">
            <div class="flex justify-between items-center mb-4">
                <button wire:click="sortBy('date')">
                    Date
                    @if ($sortField === 'date')
                        @if ($sortDirection === 'asc')
                            &#9650;
                        @else
                            &#9660;
                        @endif
                    @endif
                </button>
            </div>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="border-t border-gray-200">

                    @php
                        $balance = 0;

                    @endphp
                    @foreach ($transactions as $transaction)
                        @php
                            if ($transaction->type === 'credit') {
                                $balance -= $transaction->amount;
                            } else {
                                $balance += $transaction->amount;
                            }
                        @endphp
                        <div class="bg-white border-b border-gray-200">
                            <div class="px-4 py-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        {{ $transaction->date }}
                                    </div>
                                    <div
                                        class="w-16 px-2 flex items-center justify-end font-semibold bg-red-50/50 text-red-600 text-right">
                                        {{ $transaction->type === 'debit' ? number_format($transaction->amount, 2) : '' }}
                                    </div>
                                    <div
                                        class="w-16 px-2 flex items-center justify-end font-semibold bg-green-50/50 text-green-600 text-right">
                                        {{ $transaction->type === 'credit' ? number_format($transaction->amount, 2) : '' }}
                                    </div>
                                    <div
                                        class="w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold text-right">
                                        {{ number_format(abs($balance), 2) }}
                                        <span
                                            class="{{ $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '') }}">
                                            <span
                                                class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-2 border-t gap-2">
            <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'd']) }}"
                wire:navigate class="bg-red-700 text-white px-4 py-1 rounded flex-grow">You
                Give</button>
            <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'c']) }}"
                wire:navigate class="bg-green-700 text-white px-4 py-1 rounded flex-grow">You
                Got</button>
        </div>
    </x-slot:footer>
</x-wrapper-layout>
