<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all>
            Anshu Medical Hall
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto p-5">
        <div class="mb-5 bg-blue-700 px-3 py-1 text-white rounded-md inline-block">Total Customers :{{ $customerNumber }}
        </div>
        <div class="mb-5 bg-blue-700 px-3 py-1 text-white rounded-md inline-block">Total Dues : {{ $balance }}/-
        </div>
        <div class="flex flex-col gap-1 grow overflow-y-auto overflow-x-hidden">

            <a href="{{ route('customers') }}" wire:navigate
                class="bg-blue-600 rounded text-white px-5 py-3 flex justify-between">Customer
                List <x-icons.arrow-right /> </a>
        </div>


    </main>



    <x-slot:footer>
        =
    </x-slot:footer>

</x-wrapper-layout>
