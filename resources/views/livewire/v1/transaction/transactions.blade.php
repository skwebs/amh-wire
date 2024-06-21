<div class="relative overflow-clip bg-gray-200 shadow">

    <div class="mx-auto max-w-96 overflow-clip relative">
        <div class="bg-white h-dvh flex flex-col">

            <div class="bg-blue-800 text-white flex ">

                <a class="flex justify-center items-center aspect-square bg-transparent h-full hover:bg-white/10 text-center "
                    href="{{ route('customers') }}" wire:navigate>
                    <x-icons.left-arrow />
                </a>

                <div class="flex gap-x-3 p-2">
                    <a wire:navigate href="{{ route('customer.details', $customer) }}"
                        class="flex justify-center items-center aspect-square h-full">
                        <x-icons.user-cirlce />
                    </a>
                    <div>
                        <div class=" text-nowrap">{{ $customer->name }}</div>
                        <div class="text-nowrap px-2 font-bold text-center">
                            Bal: ₹
                            {{ number_format(abs($this->calculateBalance()), 2) }}

                            <span {{-- @class([
                                ' text-green-600' => $this->calculateBalance() < 0,
                                ' text-red-600' => $this->calculateBalance() >= 0,
                                'w-fit ms-1',
                            ]) --}}>
                                {{-- {{ number_format(abs($this->calculateBalance()), 2) }} --}}
                                {{ $this->calculateBalance() >= 0 ? 'Cr' : 'Dr' }}
                            </span>
                        </div>
                    </div>
                    <div></div>
                </div>

            </div>

            <div class="w-full p-2 flex gap-2 ">
                <input type="search" name="search" id="search" class="rounded p-1 border w-full ">
                <button class="bg-sky-500 text-white px-2 rounded flex items-center gap-2" type="submit">
                    <x-icons.magnifying-glass /> Search
                </button>
            </div>

            <div class="flex font-semibold p-2 w-full py-1 border-b text-xs text-cente">
                <div class="flex-grow">Date Time</div>
                <div class="w-16 text-red-700">Given</div>
                <div class="w-16 text-green-600">Taken</div>
                {{-- <div class="w-16 text-gray-600 text-nowrap">Balance</div> --}}
            </div>

            <div id="transactions-table-body" x-data x-init="$nextTick(() => {
                const el = document.getElementById('transactions-table-body');
                el.scrollTop = el.scrollHeight;
            })"
                @transactionsUpdated.window="$nextTick(() => { const el = document.getElementById('transactions-table-body'); el.scrollTop = el.scrollHeight; })"
                class="bg-gray-100 flex flex-col gap-y-2 px-2 grow overflow-y-auto overflow-x-hidden py-2">

                @php
                    $balance = 0;
                @endphp
                @foreach ($transactions as $transaction)
                    @php
                        if ($transaction->type === 'debit') {
                            $balance -= $transaction->amount;
                        } else {
                            $balance += $transaction->amount;
                        }
                    @endphp

                    <div
                        class="  bg-white overflow-hidden group/customer relative text-xs  w-full  min-h-14 shadow hover:bg-gray-50  transition-all duration-100 ">
                        <a class="relative  w-full rounded h-full flex"
                            href="{{ route('customer.transaction.details', ['customer' => $customer->id, 'transaction' => $transaction]) }}"
                            wire:navigate>

                            <div class="flex-grow px-2 py-1 text-xs flex flex-col justify-around">
                                <div class="text-gray-700">{{ $transaction->date }}</div>
                                <div>
                                    Bal. <span @class([
                                        'bg-green-50 text-green-600' => $balance >= 0,
                                        'bg-red-50 text-red-600' => $balance < 0,
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

                                <span @class([
                                    ' text-green-600' => $balance >= 0,
                                    ' text-red-600' => $balance < 0,
                                    'w-fit ms-1',
                                ])> {{ $balance >= 0 ? 'Cr' : 'Dr' }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="w-full flex justify-around p-2 border-t gap-2">

                <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'd']) }}"
                    wire:navigate class="bg-red-700 text-white px-4 py-1 rounded flex-grow">You
                    Give</button>
                <button href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'c']) }}"
                    wire:navigate class="bg-green-700 text-white px-4 py-1 rounded flex-grow">You
                    Got</button>
            </div>

        </div>
    </div>

</div>
