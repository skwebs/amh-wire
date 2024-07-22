<x-wrapper-layout class=" bg-blue-50">
    @if ($validated)

        <x-slot:header>
            @php
                $cBal = $customer->balance;
            @endphp
            <x-header-all class="{{ $cBal > 0 ? 'bg-red-700' : ($cBal < 0 ? 'bg-green-700' : '') }}">
                <div class="flex justify-center items-center ">
                    <div class="aspect-square h-full">
                        <x-icons.user-cirlce />
                    </div>
                    <div>
                        <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                        <div class="text-nowrap font-bold text-sm text-center">
                            Bal: ₹
                            {{ number_format(abs($cBal), 2) }}
                            <span class="{{ $cBal > 0 ? 'text-red-200' : ($cBal < 0 ? 'text-green-300' : '') }}">
                                {{ $cBal > 0 ? 'Dr' : ($cBal < 0 ? 'Cr' : '') }}
                            </span>
                        </div>
                    </div>
                </div>

            </x-header-all>
            <div class="flex font-semibold p-2 w-full py-1 border-b ">
                <div wire:click="sortBy('date')" class="flex-[2] py-2">Date</div>
                <div class="text-center flex-1 py-2 text-red-700">Dues</div>
                <div class="text-center flex-1 py-2 text-green-600">Payment</div>
                {{-- <div class="w-16 py-2 text-gray-600 text-nowrap">Balance</div> --}}
            </div>
        </x-slot:header>


        <main class="flex-grow bg-blue-50 overflow-y-auto">

            <div id="transactions-table-body" x-data x-init="$nextTick(() => {
                const el = document.getElementById('transactions-table-body');
                el.scrollTop = el.scrollHeight;
            })"
                @transactionsUpdated.window="$nextTick(() => { const el = document.getElementById('transactions-table-body'); el.scrollTop = el.scrollHeight; })"
                class="bg-gray-100 flex flex-col gap-y grow overflow-y-auto overflow-x-hidden py-2">

                @php
                    $balance = 0;
                @endphp


                @foreach ($transactions as $transaction)
                    {{-- @php
                if ($transaction->type === 'credit') {
                    $balance -= $transaction->amount;
                } else {
                    $balance += $transaction->amount;
                }
            @endphp --}}

                    <div
                        class=" border-t-2 bg-white overflow-hidden group/customer relative  w-full shadow hover:bg-gray-50  transition-all duration-100 ">
                        <div class="relative  w-full rounded h-full flex">

                            <div class="flex-[2] px-2 py-2 flex flex-col justify-around">
                                <div class="text-gray-700">{{ $transaction->date }}</div>
                                <div>

                                    {{-- Bal. <span @class([
                                '' => $balance === 0,
                                'bg-green-50 text-green-600' => $balance < 0,
                                'bg-red-50 text-red-600' => $balance >= 0,
                                'w-fit px-2',
                            ])>
                                {{ number_format(abs($balance), 2) }}
                            </span> --}}
                                </div>
                            </div>
                            <div
                                class="flex-1 px-2 flex items-center justify-end font-semibold bg-red-50/50 text-red-600 text-right">
                                {{ $transaction->type === 'debit' ? number_format($transaction->amount, 2) : '' }}

                            </div>
                            <div
                                class="flex-1 px-2 flex items-center justify-end font-semibold bg-green-50/50 text-green-600 text-right">
                                {{ $transaction->type === 'credit' ? number_format($transaction->amount, 2) : '' }}

                            </div>
                            {{-- <div
                        class="w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold  text-right">
                        {{ number_format(abs($balance), 2) }}

                        <span class="{{ $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '') }}">
                            <span
                                class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                        </span>
                    </div> --}}
                        </div>
                    </div>
                @endforeach

            </div>

        </main>

        <x-slot:footer>
            <div class="w-full flex justify-around p-2 border-t ">
                This is online generated statement
            </div>
        </x-slot:footer>
    @else
        <div class="">
            <div class="bg-red-600 text-white p-3">Invalid link</div>
        </div>
    @endif
</x-wrapper-layout>
