<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customers') }}" :back="false">
            Anshu Medical Hall
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto p-5">
        <div class="flex flex-col gap-1 grow overflow-y-auto overflow-x-hidden">

            <a href="{{ route('customers') }}" wire:navigate class="bg-blue-600 rounded text-white px-5 py-3">Customer
                List</a>
        </div>
    </main>



    <x-slot:footer>
        =
    </x-slot:footer>

</x-wrapper-layout>
