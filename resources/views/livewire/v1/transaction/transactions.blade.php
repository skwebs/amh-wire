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
        <div class="flex font-semibold p-2 w-full py-1 border-b text-xs flex-col">
            <div class="flex w-full ">
                <div wire:click="sortBy('date')" class="flex-[2]">DateTime</div>
                <div class="text-center flex-1 ">
                    <span class="text-red-600">Dr</span>/<span class="text-green-600 ">Cr</span>
                </div>
                <div class="w-24 text-gray-600 text-nowrap ">Balance</div>
            </div>
            <div class="w-full text-gray-400">Description</div>
        </div>
    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">

        <div class="relative bg-gray-100 flex flex-col gap-y-2 grow overflow-y-auto overflow-x-hidden p-2">

            @php
                $balance = $this->calculateBalance();
            @endphp
            @if ($transactions)
                @foreach ($transactions as $date => $groupedTransaction)
                    <span
                        class="{{ date('w', strtotime($date)) == 0 ? 'text-red-600' : '' }} inline-block rounded text-center text-xs bg-white w-fit px-2 py-1 mx-auto sticky top-24">{{ date('D, d M Y', strtotime($date)) }}</span>

                    @foreach ($groupedTransaction as $transaction)
                        <div
                            class="text-xs rounded bg-white overflow-hidden group/customer   w-full shadow hover:bg-gray-50  transition-all duration-100 ">
                            <a class="  w-full rounded h-full flex"
                                href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}"
                                wire:navigate>

                                <div class="flex w-full flex-col p-2">

                                    <div class="flex gap-4">
                                        <div class="flex-[2]  flex flex-col justify-around">
                                            <div class="text-gray-700">
                                                @php
                                                    $transactionDate = strtotime($transaction->datetime);
                                                @endphp
                                                {{-- <span
                                                    class="{{ date('w', $transactionDate) == 0 ? 'text-red-600' : '' }} text-xs">
                                                    {{ date('D', $transactionDate) }}
                                                </span> --}}
                                                {{ date('d M Y-h:iA', $transactionDate) }}

                                            </div>
                                        </div>
                                        <div
                                            class="{{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }} flex-1 px-2 flex items-center justify-end font-semibold   text-right">
                                            {{ '₹ ' . number_format($transaction->amount, 2) }}
                                        </div>
                                        <div
                                            class=" w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold  text-right">
                                            ₹ {{ number_format(abs($balance), 2) }}
                                            <span
                                                class="{{ $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '') }}">
                                                <span
                                                    class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-gray-400">
                                        {{ $transaction->particulars == '' ? ucfirst($transaction->type) . 'ed ₹ ' . $transaction->amount : $transaction->particulars }}
                                    </div>

                                </div>
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
            @else
                <div class="text-sm text-center text-gray-400 font-semibold">No Transaction</div>
            @endif


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
