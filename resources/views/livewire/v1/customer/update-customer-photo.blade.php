<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customer.transactions', $customer->id) }}">
            <a wire:navigate href="{{ route('customer.update-photo', $customer) }}"
                class="flex justify-center items-center ">
                <div class="aspect-square h-full">
                    <x-icons.user-cirlce />
                </div>
                <div>
                    <div class=" text-nowrap text-sm">{{ $customer->name }}</div>
                    <div class="text-nowrap font-bold text-sm text-center">
                        Customer Details
                    </div>
                </div>
            </a>

        </x-header-all>
    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">

        <form class="mt-4 bg-white p-4 rounded-md" wire:submit='save'>
            <div wire:loading wire:target="photo" class="fixed z-10 bg-black/50 inset-0 flex justify-center items-center align-middle w-full h-svh">
                <div class="text-white">Loading...</div>
            </div>
            <div class="mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 ">Upload Image</label>
                <input type="file" wire:model='photo'
                    class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer ">
                @if ($photo)
                    <img class="size-32 rounded-md" src="{{ $photo->temporaryUrl() }}" alt="updload image">
                @endif
            </div>
            <button type="submit">Upload</button>
        </form>
        {{-- <form wire:submit="save">
            <input type="file" wire:model="photo">

            @error('photo') <span class="error">{{ $message }}</span> @enderror

            <button class="bg-gray-300 px-3 py-2 rounded-sm" type="submit">Save photo</button>
        </form> --}}
    </main>



    <x-slot:footer>
        <div class="w-full flex justify-around p-4 border-t gap-4">

            {{-- <button href="{{ route('customer.transactions', $customer) }}" wire:navigate
                class="bg-gray-500 text-white px-4 py-1 rounded flex-grow">Go Back</button> --}}


        </div>
    </x-slot:footer>



</x-wrapper-layout>
