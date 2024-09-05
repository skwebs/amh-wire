<x-wrapper-layout class="{{ $transactionType === 'credit' ? 'bg-green-50' : 'bg-red-50 ' }}">
    <x-slot:header>
        <x-header-all class="{{ $transactionType === 'credit' ? 'bg-green-700' : 'bg-red-700 ' }}"
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
                <x-input name="amount" label="Amount" type="number" placeholder="Amount" model="amount" />
                <x-input name="date" label="Transaction Date" type="date" placeholder="Date" model="date" />
                <x-input name="particulars" label="Particulars" placeholder="Particulars" model="particulars" />
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
