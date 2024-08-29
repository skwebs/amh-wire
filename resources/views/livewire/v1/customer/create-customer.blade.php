<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customers') }}">
            Add New Customer
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
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
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-600">Email</label>
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="Email"
                            wire:model="email"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('email')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-600">Phone
                            Number</label>
                        <input type="tel" name="phone" id="phone" autocomplete="phone" placeholder="Phone"
                            wire:model="phone"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('phone')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <label for="address" class="block text-sm font-medium leading-6 text-gray-600">Address</label>
                        <input type="text" name="address" id="address" autocomplete="address" placeholder="Address"
                            wire:model="address"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="h-3">
                        @error('address')
                            <div class="text-red-600 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <div class="flex gap-5 my-4">
                    <button type="submit"
                        class=" w-full bg-green-700 hover:bg-green-800 text-white rounded-md px-3 py-2 font-semibold">Submit</button>
                </div>

            </form>

        </div>
    </main>
    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">

            <a href="{{ route('customers') }}" wire:navigate
                class="text-center w-full inline-block bg-gray-600 hover:bg-gray-700 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>

        </div>
    </x-slot:footer>
</x-wrapper-layout>
