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
                            {{ $cBal > 0 ? 'Dr' : ($cBal < 0 ? 'Cr' : '') }}
                        </span>
                    </div>
                </div>
            </a>

        </x-header-all>
        <div class="flex font-semibold p-2 w-full py-1 border-b ">
            <div wire:click="sortBy('date')" class="flex-[2] py-2">Date</div>
            <div class="text-center flex-1 py-2 text-red-700">Given</div>
            <div class="text-center flex-1 py-2 text-green-600">Taken</div>
            {{-- <div class="w-16 py-2 text-gray-600 text-nowrap">Balance</div> --}}
        </div>
    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">

        <div id="transactions-table-body" x-data x-init="$nextTick(() => {
            const el = document.getElementById('transactions-table-body');
            el.scrollTop = el.scrollHeight;
        })"
            @transactionsUpdated.window="$nextTick(() => { const el = document.getElementById('transactions-table-body'); el.scrollTop = el.scrollHeight; })"
            class="bg-gray-100 flex flex-col gap-y-2 grow overflow-y-auto overflow-x-hidden p-2">

            @php
                $balance = $this->calculateBalance();

            @endphp

            @foreach ($transactions as $date => $groupedTransaction)
                <span class="inline-block rounded text-center text-xs bg-white w-fit px-2 py-1 mx-auto">{{ date('d M Y', strtotime($date)) }}</span>
                @foreach ($groupedTransaction as $transaction)
                    <div
                        class="text-xs rounded bg-white overflow-hidden group/customer relative  w-full shadow hover:bg-gray-50  transition-all duration-100 ">
                        <a class="relative  w-full rounded h-full flex"
                            href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}"
                            wire:navigate>

                            <div class="flex-[2] px-2 py-2 flex flex-col justify-around">
                                <div class="text-gray-700">{{ date('d-m-Y', strtotime($transaction->date)) }}</div>
                                <div>
                                    <span class="bg-amber-50 text-amber-600">
                                        <span
                                            class="{{ $balance > 0 ? 'bg-red-50 text-red-600' : ($balance < 0 ? 'bg-green-50 text-green-600' : '') }} w-fit px-1">
                                            Bal. ₹ {{ number_format(abs($balance), 2) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div
                                class="flex-1 px-2 flex items-center justify-end font-semibold bg-red-50/50 text-red-600 text-right">
                                {{ $transaction->type === 'debit' ? '₹ ' . number_format($transaction->amount, 2) : '' }}

                            </div>
                            <div
                                class="flex-1 px-2 flex items-center justify-end font-semibold bg-green-50/50 text-green-600 text-right">
                                {{ $transaction->type === 'credit' ? '₹ ' . number_format($transaction->amount, 2) : '' }}

                            </div>

                            {{-- <div
                                class="w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold  text-right">
                                {{ number_format(abs($balance), 2) }}

                                <span
                                    class="{{ $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '') }}">
                                    <span
                                        class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                                </span>
                            </div> --}}

                        </a>
                    </div>

                    @php
                        if ($transaction->type === 'credit') {
                            $balance += $transaction->amount;
                        } else {
                            $balance -= $transaction->amount;
                        }
                    @endphp
                @endforeach
            @endforeach

        </div>

    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4 bg-white">
            <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'd']) }}"
                wire:navigate class="bg-red-600 text-white px-4 py-2 rounded flex-grow">You
                Gave ₹</button>
            <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'c']) }}"
                wire:navigate class="bg-green-700 text-white px-4 py-2 rounded flex-grow">You
                Got ₹</button>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
