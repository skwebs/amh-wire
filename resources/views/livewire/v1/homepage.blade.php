<x-wrapper-layout class="bg-blue-50">
    <x-slot:header class="bg-red-300">

        <x-header-all>
            {{ $user->name }}
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow overflow-y-auto bg-blue-50 p-5">


        <div
            class="{{ $cashBalance < 0 ? 'bg-red-600' : 'bg-green-600' }} mb-5 inline-block rounded-md bg-red-600 px-3 py-2 text-white">
            Cash Balance
            : {{ $cashBalance }}
        </div>
        <div
            class="{{ $banksBalance < 0 ? 'bg-red-600' : 'bg-green-600' }} mb-5 inline-block rounded-md bg-blue-700 px-3 py-2 text-white">
            Bank Balance
            : {{ $banksBalance }}
        </div>
        <div
            class="{{ $creditCardsExpenses < 0 ? 'bg-red-600' : 'bg-green-600' }} mb-5 inline-block rounded-md px-3 py-2 text-white">
            Credit Card Expenses
            : {{ abs($creditCardsExpenses) }}
        </div>

        <div
            class="{{ $otherBalance < 0 ? 'bg-red-600' : 'bg-green-600' }} mb-5 inline-block rounded-md px-3 py-2 text-white">
            Other Balance
            : {{ abs($otherBalance) }}
        </div>
        {{-- <div class="mb-5 inline-block rounded-md bg-blue-700 px-3 py-1 text-white">Total Customers
            :{{ $customerNumber }}
        </div>
        <div class="mb-5 inline-block rounded-md bg-blue-700 px-3 py-1 text-white">Total Dues : {{ $balance }}/-
        </div> --}}
        <div class="flex grow flex-col gap-1 overflow-y-auto overflow-x-hidden">

            <a href="{{ route('customers') }}" wire:navigate
                class="flex justify-between rounded bg-blue-600 px-5 py-3 text-white">
                List <x-icons.arrow-right /> </a>
        </div>




    </main>



    <x-slot:footer>
        {{-- logout button --}}
        <div class="m-5 flex">
            <button wire:click="logout" class="w-full rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                Logout
            </button>
        </div>
    </x-slot:footer>

</x-wrapper-layout>
