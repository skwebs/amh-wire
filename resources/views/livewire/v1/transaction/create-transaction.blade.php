<x-wrapper-layout class="{{ $transactionType === 'credit' ? 'bg-green-50' : 'bg-red-50 ' }}">
    <x-slot:header>
        <x-header-all @class([
            'bg-green-700 ' => $transactionType == 'credit',
            'bg-red-700 ' => $transactionType == 'debit',
        ])
            href="{{ route('customer.transactions', $customer) }}">
            {{ $transactionType === 'credit' ? 'Receiving Money' : 'Selling Goods' }}
        </x-header-all>
    </x-slot:header>

    <main class="flex-grow  overflow-y-auto">
        <div class="p-5">
            <h2 class="mb-5 text-2xl {{ $transactionType === 'credit' ? 'text-green-700' : 'text-red-700' }}">
                {{ $transactionType === 'credit' ? 'Receiving from' : 'Giving to' }} {{ $customer->name }}
            </h2>
            <form class="flex flex-col gap-2" wire:submit.prevent="saveTransaction">
                <!-- /added above code -->
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
                <!-- /added above code -->

                {{-- <x-input name="amount" step=".01" label="Amount" type="number" placeholder="Amount"
                    model="amount" />
                <x-input name="datetime" label="Transaction Datetime" type="datetime-local" placeholder="Datetime"
                    model="datetime" /> --}}
                {{-- <x-input name="particulars" label="Particulars" placeholder="Particulars" model="particulars" /> --}}
                <div class="w-full flex justify-around">
                    <button type="submit"
                        class="w-full {{ $transactionType === 'credit' ? 'bg-green-700 hover:bg-green-800' : 'bg-red-700 hover:bg-red-800' }} text-white rounded-md px-3 py-2 font-semibold">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </main>

    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">

            <a wire:navigate href="{{ route('customer.transactions', $customer) }}"
                class="text-center w-full inline-block bg-gray-500 hover:bg-gray-600 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>
        </div>
    </x-slot:footer>
</x-wrapper-layout>
