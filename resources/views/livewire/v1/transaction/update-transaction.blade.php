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
                <!-- Amount -->
                <div>
                    <x-input-label for="amount" :value="__('Amount')" />
                    <x-text-input wire:model="amount" id="amount" class="block mt-1 w-full" type="number"
                        step=".01" name="amount" required autofocus autocomplete="transaction-amount" />
                    <div class="min-h-4">
                        <x-input-error :messages="$errors->get('amount')" class="text-xs" />
                    </div>
                </div>

                <!-- Date time -->
                <div>
                    <x-input-label for="datetime" :value="__('Txn DateTime')" />
                    <x-text-input wire:model="datetime" id="datetime" class="block mt-1 w-full" type="datetime-local"
                        name="datetime" required autocomplete="current-datetime" />
                    <div class="min-h-4">
                        <x-input-error :messages="$errors->get('datetime')" class="text-xs" />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="particulars" :value="__('Particulars')" />
                    <x-text-input wire:model="particulars" id="particulars" class="block mt-1 w-full" type="text"
                        step=".01" name="particulars" autofocus autocomplete="transaction-description" />
                    <div class="min-h-4">
                        <x-input-error :messages="$errors->get('particulars')" class="text-xs" />
                    </div>
                </div>

                <!-- Txn Type -->
                <div>
                    <div class="text-sm">Existing Txn type : <span
                            class="capitalize font-bold {{ $transaction->type == 'credit' ? ' text-green-700 ' : ' text-red-700  ' }}">{{ $transaction->type }}</span>
                    </div>
                    <x-input-label for="type" :value="__('Txn Type')" />
                    <select id="type" wire:model.change="type"
                        class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                        <option @if ($type == 'debit') selected @endif value="debit">Debit</option>
                        <option @if ($type == 'credit') selected @endif value="credit">Credit</option>
                    </select>
                    <div class="min-h-4">
                        <x-input-error :messages="$errors->get('type')" class="text-xs" />
                    </div>
                </div>
                <!-- /added above code -->

                <div class="w-full flex justify-around mt-2 gap-2">
                    <button type="submit"
                        class="{{ $type == 'credit' ? ' bg-green-700 hover:bg-green-800 ' : ' bg-red-700 hover:bg-red-800 ' }} w-full  text-white rounded-md px-3 py-2 font-semibold">Update</button>
                </div>
            </form>
        </div>

    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">
            <a href="{{ route('customer.transaction.details', ['customer' => $customer, 'transaction' => $transaction]) }}"
                class="text-center w-full inline-block bg-gray-500 hover:bg-gray-600 text-white rounded-md px-3 py-2 font-semibold"
                wire:navigate>Go
                Back</a>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
