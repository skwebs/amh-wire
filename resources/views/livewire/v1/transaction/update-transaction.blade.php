<x-wrapper-layout class=" bg-blue-50">

    <x-slot:header>
        <x-header-all class="{{ $transaction->type == 'credit' ? ' bg-green-700 ' : ' bg-red-700  ' }}"
            href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}">
            Update Transaction Details
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="p-5">
            <h2 class="mb-5 text-2xl {{ $type == 'credit' ? ' text-green-700 ' : ' text-red-700  ' }}">
                {{ $customer->name }}</h2>

            <form class="flex flex-col gap-2" wire:submit="updateTransaction">

                <div class="">

                    <div class="">
                        <input type="text" name="amount" id="amount" autocomplete="currency"
                            placeholder="Getting Amount" wire:model="amount"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-4">
                        @error('amount')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="">

                    <div class="">
                        <label for="date" class="block text-sm font-medium leading-6 text-gray-600">Transaction
                            Date</label>
                        <input type="date" name="date" id="date" autocomplete="date" placeholder="Date"
                            wire:model="date"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-4">
                        @error('date')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="">
                    <div>Existing Txn type : <span
                            class="capitalize font-bold {{ $transaction->type == 'credit' ? ' text-green-700 ' : ' text-red-700  ' }}">{{ $transaction->type }}</span>
                    </div>
                    <div class="">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-600">Transaction
                            Type</label>
                        <select id="type" wire:model.change="type"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                            <option @if ($type == 'debit') selected @endif value="debit">Debit</option>
                            <option @if ($type == 'credit') selected @endif value="credit">Credit</option>
                        </select>
                    </div>

                    <div class="h-4">
                        @error('date')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="w-full flex justify-around p-2 gap-2">

                    <button type="submit"
                        class="{{ $type == 'credit' ? ' bg-green-700 hover:bg-green-800 ' : ' bg-red-700 hover:bg-red-800 ' }} w-full  text-white rounded-md px-3 py-2 font-semibold">Update</button>
                </div>
            </form>

        </div>

    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-2 border-t gap-2">
            <a href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}"
                class="text-center w-full inline-block bg-gray-500 hover:bg-gray-600 text-white rounded-md px-3 py-2 font-semibold"
                wire:navigate>Go
                Back</a>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
