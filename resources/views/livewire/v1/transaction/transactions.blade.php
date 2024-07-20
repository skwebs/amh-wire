<x-wrapper-layout class=" bg-blue-50">

    <x-slot:header>
        <x-header-all href="{{ route('customers') }}" :back="true">
            <a wire:navigate href="{{ route('customer.details', $customer) }}" class="flex justify-center items-center ">
                <div class="aspect-square h-full">
                    <x-icons.user-cirlce />
                </div>
                <div>
                    <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                    <div class="text-nowrap font-bold text-sm text-center">
                        @php
                            $cBal = $this->calculateBalance();
                        @endphp
                        Bal: ₹
                        {{ number_format(abs($this->calculateBalance()), 2) }}
                        <span class="{{ $cBal > 0 ? 'text-red-300' : ($cBal < 0 ? 'text-green-300' : '') }}">
                            {{ $cBal > 0 ? 'Dr' : ($cBal < 0 ? 'Cr' : '') }}
                        </span>
                    </div>
                </div>
            </a>

        </x-header-all>
        <div class="flex font-semibold p-2 w-full py-1 border-b text-xs">
            <div class="flex-grow">Date Time</div>
            <div class="w-16 text-red-700">Given</div>
            <div class="w-16 text-green-600">Taken</div>
            <div class="w-16 text-gray-600 text-nowrap">Balance</div>
        </div>
    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">

        <div id="transactions-table-body" x-data x-init="$nextTick(() => {
            const el = document.getElementById('transactions-table-body');
            el.scrollTop = el.scrollHeight;
        })"
            @transactionsUpdated.window="$nextTick(() => { const el = document.getElementById('transactions-table-body'); el.scrollTop = el.scrollHeight; })"
            class="bg-gray-100 flex flex-col gap-y-2 grow overflow-y-auto overflow-x-hidden py-2">

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

                <div
                    class="  bg-white overflow-hidden group/customer relative text-xs  w-full shadow hover:bg-gray-50  transition-all duration-100 ">
                    <a class="relative  w-full rounded h-full flex"
                        href="{{ route('customer.transaction.details', ['customer' => $customer->id, 'transaction' => $transaction]) }}"
                        wire:navigate>

                        <div class="flex-grow px-2 py-2 text-xs flex flex-col justify-around">
                            <div class="text-gray-700">{{ $transaction->date }}</div>
                            <div>

                                Bal. <span @class([
                                    '' => $balance === 0,
                                    'bg-green-50 text-green-600' => $balance < 0,
                                    'bg-red-50 text-red-600' => $balance >= 0,
                                    'w-fit px-2',
                                ])>
                                    {{ number_format(abs($balance), 2) }}
                                </span>
                            </div>
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
                            class="w-24 px-2 text-gray-600 text-nowrap flex items-center justify-end font-semibold  text-right">
                            {{ number_format(abs($balance), 2) }}

                            {{-- @php
                                $c = $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '');
                                $type = $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : null);
                            @endphp
                            <span class="{{ $c }}">&nbsp;{{ $type }}</span> --}}

                            <span class="{{ $balance > 0 ? 'text-red-600' : ($balance < 0 ? 'text-green-600' : '') }}">
                                <span
                                    class="ml-1 w-4 inline-block">{{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}</span>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
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
