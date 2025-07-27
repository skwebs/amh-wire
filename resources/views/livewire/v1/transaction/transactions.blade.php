<x-wrapper-layout class="bg-blue-50">
    <x-slot:header>
        <x-header-all href="{{ route('customers') }}" @class(['bg-red-700' => $balance > 0, 'bg-green-700' => $balance < 0])>
            <a wire:navigate href="{{ route('customer.details', $customer) }}" class="flex items-center justify-center">
                <div class="aspect-square h-full">
                    <x-icons.user-circle />
                </div>
                <div>
                    <div class="text-nowrap text-sm">{{ $customer->name }}</div>
                    <div class="text-nowrap text-center text-sm font-bold">
                        Bal: ₹ {{ number_format(abs($balance), 2) }}
                        <span @class([
                            'text-red-200' => $balance > 0,
                            'text-green-300' => $balance < 0,
                        ])>
                            {{ $balance > 0 ? 'Dr' : ($balance < 0 ? 'Cr' : '') }}
                        </span>
                    </div>
                </div>
            </a>
        </x-header-all>
        <div class="flex w-full flex-col border-b p-2 py-1 text-xs font-semibold">
            <div class="flex w-full">
                <div wire:click="sortBy('datetime')" class="flex-[2] cursor-pointer">DateTime</div>
                <div class="flex-1 text-center">
                    <span class="text-red-600">Dr</span>/<span class="text-green-600">Cr</span>
                </div>
                <div class="w-24 text-nowrap text-gray-600">Balance</div>
            </div>
            <div class="w-full text-gray-400">Description</div>
        </div>
    </x-slot:header>

    <main class="flex-grow overflow-y-auto bg-blue-50">
        <div class="relative flex grow flex-col gap-y-2 overflow-y-auto overflow-x-hidden bg-gray-100 p-2">
            @if ($transactions)
                @php $runningBalance = $balance; @endphp
                @foreach ($transactions as $date => $groupedTransaction)
                    <span @class([
                        'inline-block rounded text-center text-xs bg-white w-fit px-2 py-1 mx-auto',
                        'text-red-600' => date('w', strtotime($date)) == 0,
                    ])>
                        {{ date('D, d M Y', strtotime($date)) }}
                    </span>
                    @foreach ($groupedTransaction as $transaction)
                        <div
                            class="group/customer w-full overflow-hidden rounded bg-white text-xs shadow transition-all duration-100 hover:bg-gray-50">
                            <a class="flex h-full w-full rounded"
                                href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}"
                                wire:navigate>
                                <div class="flex w-full flex-col p-2">
                                    <div class="flex gap-4">
                                        <div class="flex flex-[2] flex-col justify-around">
                                            <div class="text-gray-700">
                                                {{ $transaction->datetime->format('d M Y - h:i A') }}
                                            </div>
                                        </div>
                                        <div @class([
                                            'flex-1 px-2 flex items-center justify-end font-semibold text-right',
                                            'text-green-600' => $transaction->type === 'credit',
                                            'text-red-600' => $transaction->type === 'debit',
                                        ])>
                                            ₹ {{ number_format($transaction->amount, 2) }}
                                        </div>
                                        <div
                                            class="flex w-24 items-center justify-end text-nowrap px-2 text-right font-semibold text-gray-600">
                                            ₹ {{ number_format(abs($runningBalance), 2) }}
                                            <span @class([
                                                'text-red-600' => $runningBalance > 0,
                                                'text-green-600' => $runningBalance < 0,
                                            ])>
                                                <span
                                                    class="ml-1 inline-block w-4">{{ $runningBalance > 0 ? 'Dr' : ($runningBalance < 0 ? 'Cr' : '') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-gray-400">
                                        {{ $transaction->particulars ?: ucfirst($transaction->type) . 'ed ₹ ' . number_format($transaction->amount, 2) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                        @php
                            $runningBalance +=
                                $transaction->type === 'credit' ? $transaction->amount : -$transaction->amount;
                        @endphp
                    @endforeach
                @endforeach
            @else
                <div class="text-center text-sm font-semibold text-gray-400">
                    No transactions found. <a wire:navigate
                        href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'd']) }}"
                        class="text-blue-600">Add one now</a>.
                </div>
            @endif
        </div>
    </main>

    <x-slot:footer>
        <div class="flex w-full justify-around gap-4 border-t bg-white p-4">
            <a href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'd']) }}"
                wire:navigate class="flex-grow rounded bg-red-600 px-4 py-2 text-center text-white">You Gave ₹</a>
            <a href="{{ route('customer.transaction.create', ['customer' => $customer, 'type' => 'c']) }}"
                wire:navigate class="flex-grow rounded bg-green-700 px-4 py-2 text-center text-white">You Got ₹</a>
        </div>
    </x-slot:footer>
</x-wrapper-layout>
