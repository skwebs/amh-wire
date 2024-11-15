<x-wrapper-layout class=" bg-blue-50">
    @if ($validated)
        <x-slot:header>
            @php
                $balance = $customer->balance;
            @endphp
            <x-header-all @class(['bg-red-700' => $balance > 0, 'bg-green-700' => $balance < 0])>

                <span class="flex justify-center items-center ">
                    <div class="aspect-square h-full">
                        <x-icons.user-cirlce />
                    </div>
                    <div>
                        <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                        <div class="text-nowrap font-bold text-sm text-center">
                            Bal: ₹
                            {{ number_format(abs($balance), 2) }}
                            <span @class([
                                'text-red-200' => $balance > 0,
                                'text-green-200' => $balance < 0,
                            ])>
                                {{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}
                            </span>
                        </div>
                    </div>
                </span>

            </x-header-all>

            <div class="flex font-semibold p-2 w-full py-1 border-b text-xs flex-col">
                <div class="flex w-full ">
                    <div wire:click="sortBy('date')" class="flex-[2]">Date</div>
                    <div class="text-center flex-1 ">
                        <span class="text-red-600">Dues</span>/<span class="text-green-600 ">Paid</span>
                    </div>
                    <div class="w-24 text-gray-600 text-nowrap ">Balance</div>
                </div>
                <div class="w-full text-gray-400">Description</div>
            </div>
        </x-slot:header>


        <main class="flex-grow bg-blue-50 overflow-y-auto">

            <div id="transactions-table-body" x-data x-init="$nextTick(() => {
                const el = document.getElementById('transactions-table-body');
                el.scrollTop = el.scrollHeight;
            })"
                @transactionsUpdated.window="$nextTick(() => { const el = document.getElementById('transactions-table-body'); el.scrollTop = el.scrollHeight; })"
                class="bg-gray-100 flex flex-col gap-y-2 grow overflow-y-auto overflow-x-hidden p-2">


                @foreach ($transactions as $date => $groupedTransaction)
                    <span
                        class="inline-block rounded text-center text-xs bg-white w-fit px-2 py-1 mx-auto">{{ date('d M Y', strtotime($date)) }}</span>
                    @foreach ($groupedTransaction as $transaction)
                        {{-- <div
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

                            </a>
                        </div> --}}

                        <div
                            class="text-xs rounded bg-white overflow-hidden group/customer relative  w-full shadow hover:bg-gray-50  transition-all duration-100 ">
                            <span class="relative  w-full rounded h-full flex">

                                <div class="flex w-full flex-col p-2">

                                    <div class="flex gap-4">
                                        <div class="flex-[2]  flex flex-col justify-around">
                                            <div class="text-gray-700">
                                                {{ date('d-m-Y', strtotime($transaction->date)) }}
                                            </div>
                                        </div>
                                        <div @class([
                                            'flex-1 px-2 flex items-center justify-end font-semibold   text-right',
                                            'text-green-600' => $transaction->type === 'credit',
                                            'text-red-600' => $transaction->type === 'debit',
                                        ])>
                                            {{ '₹ ' . number_format($transaction->amount, 2) }}
                                        </div>
                                        <div
                                            class=" w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold  text-right">
                                            ₹ {{ number_format(abs($balance), 2) }}
                                            <span @class([
                                                'text-red-600' => $balance > 0,
                                                'text-green-600' => $balance < 0,
                                            ])>
                                                <span
                                                    class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-gray-400">
                                        {{ $transaction->particulars ?? ucfirst($transaction->type) . 'ed ₹ ' . $transaction->amount }}
                                    </div>

                                </div>
                            </span>
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
            <div class="w-full flex justify-around p-1 border-t text-gray-600 bg-white">
                This is online generated statement.
            </div>
        </x-slot:footer>
    @else
        <div class="">
            <div class="bg-red-600 text-white p-3">Invalid link</div>
        </div>
    @endif

</x-wrapper-layout>
