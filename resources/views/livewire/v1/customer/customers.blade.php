<x-wrapper-layout class=" bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all href="{{ route('customers') }}" :back="false">
            Customers List
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="flex flex-col gap-1 grow overflow-y-auto overflow-x-hidden">

            @foreach ($customers as $customer)
                <div class="w-full bg-white rounded flex h-14">
                    <div class="p-[2px]">
                        <div
                            class="bg-green-50 aspect-square h-full rounded-full border flex justify-center items-center">
                            photo
                        </div>
                    </div>
                    <div class="bg-red-50 flex flex-col justify-center  flex-grow px-1">
                        <a href="{{ route('customer.transactions', $customer->id) }}" wire:navigate>
                            <div>Name</div>
                            <div class="text-xs">Date</div>
                        </a>
                    </div>
                    <div class=" bg-blue-100 h-full flex justify-center items-center gap-x-2">
                        <div>
                            2411244
                        </div>
                        <x-icons.chevron-right />
                    </div>
                </div>
            @endforeach
        </div>
    </main>



    <x-slot:footer>
        <div class="w-full flex justify-around p-2 border-t gap-2">

            <button href="{{ route('customer.create', ['customer' => $customer, 'type' => 'd']) }}" wire:navigate
                class="bg-red-700 text-white px-4 py-1 rounded flex-grow">Add New Customer</button>

        </div>
    </x-slot:footer>

</x-wrapper-layout>
