<div>

    <div class="p-5">
        <h2 class="mb-5 text-2xl text-green-700">Receving form {{ $customer->name }}</h2>

        <form class="flex flex-col gap-2" wire:submit="saveTransaction">

            <div class="">

                <div class="">
                    <input type="text" name="amount" id="amount" autocomplete="currency" placeholder="Getting Amount"
                        wire:model="amount"
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

            <div class="flex gap-5 my-4">


                <a href="{{ route('customer.transactions', $customer) }}"
                    class="text-center w-full inline-block bg-gray-700 hover:bg-gray-800 text-white rounded-md px-3 py-2 font-semibold">Go
                    Back</a>

                <button type="submit"
                    class=" w-full bg-green-700 hover:bg-green-800 text-white rounded-md px-3 py-2 font-semibold">Submit</button>
            </div>

        </form>



    </div>

</div>
