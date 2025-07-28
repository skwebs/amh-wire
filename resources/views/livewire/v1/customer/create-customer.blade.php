<x-wrapper-layout class="bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customers') }}">
            Add New Customer
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow overflow-y-auto bg-blue-50">
        <div class="p-5">
            {{-- <h2 class="mb-5 text-2xl text-green-700">Add Customer</h2> --}}

            <form class="flex flex-col gap-2" wire:submit="addCustomer">
                <div class="">
                    <div class="">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-600">Name</label>
                        <input type="text" name="name" id="name" autocomplete="name" placeholder="Name"
                            wire:model="name"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('name')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- <div class="">
                    <div class="">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-600">Email</label>
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="Email"
                            wire:model="email"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('email')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}

                {{-- <div class="">
                    <div class="">
                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-600">Phone
                            Number</label>
                        <input type="tel" name="phone" id="phone" autocomplete="phone" placeholder="Phone"
                            wire:model="phone"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('phone')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
                <div class="">
                    <div class="">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-600">Type</label>
                        <select name="type" id="type" wire:model="type"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                            <option value="">Select Type</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="h-3">
                        @error('type')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- <div class="">
                    <div class="">
                        <label for="address" class="block text-sm font-medium leading-6 text-gray-600">Address</label>
                        <input type="text" name="address" id="address" autocomplete="address" placeholder="Address"
                            wire:model="address"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('address')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}



                <div class="my-4 flex gap-5">
                    <button type="submit"
                        class="w-full rounded-md bg-green-700 px-3 py-2 font-semibold text-white hover:bg-green-800">Submit</button>
                </div>

            </form>

        </div>
    </main>
    <x-slot:footer>
        <div class="flex w-full justify-around gap-4 border-t p-4">

            <a href="{{ route('customers') }}" wire:navigate
                class="inline-block w-full rounded-md bg-gray-600 px-3 py-2 text-center font-semibold text-white hover:bg-gray-700">Go
                Back</a>

        </div>
    </x-slot:footer>
</x-wrapper-layout>
