<x-wrapper-layout class=" bg-blue-50">

    <x-slot:header>
        <x-header-all href="{{ route('customer.transactions', $customer) }}" :back="true">

            Transaction Details
        </x-header-all>

    </x-slot:header>


    <main class="flex-grow bg-blue-50 overflow-y-auto">
        <div class="p-5">
            <h2 class="mb-5 font-semibold text-blue-600 text-2xl">{{ $customer->name }}</h2>
            <table class="table w-full border">
                <tr class="odd:bg-gray-200">
                    <td class="px-4 py-2 "> id </td>
                    <td>:</td>
                    <td class="px-4 py-2"> {{ $transaction->id }} </td>
                </tr>
                <tr class="odd:bg-gray-200">
                    <td class="px-4 py-2 "> Amount </td>
                    <td>:</td>
                    <td class="px-4 py-2"> {{ $transaction->amount }} </td>
                </tr>
                <tr class="odd:bg-gray-200">
                    <td class="px-4 py-2 "> Type </td>
                    <td>:</td>
                    <td class="px-4 py-2"> {{ $transaction->type }} </td>
                </tr>
                <tr class="odd:bg-gray-200">
                    <td class="px-4 py-2 "> Date </td>
                    <td>:</td>
                    <td class="px-4 py-2"> {{ $transaction->date }} </td>
                </tr>
                <tr class="odd:bg-gray-200">
                    <td class="px-4 py-2 "> Created At </td>
                    <td>:</td>
                    <td class="px-4 py-2"> {{ $transaction->created_at }} </td>
                </tr>
            </table>


        </div>


    </main>
    {{-- route('customer.transactions', $customer) --}}
    <x-slot:footer>
        <div class="w-full flex justify-around p-2 border-t gap-2">

            <a href="{{ route('customer.transactions', $customer) }}"
                class="text-center w-full inline-block bg-gray-700 hover:bg-gray-800 text-white rounded-md px-3 py-2 font-semibold">Go
                Back</a>
            <button type="submit" href="{{ route('customer.transactions', $transaction) }}"
                class=" w-full
                bg-blue-700 hover:bg-blue-800 text-white rounded-md px-3 py-2 font-semibold">Update</button>


        </div>
    </x-slot:footer>

</x-wrapper-layout>
