<div class="relative overflow-clip">

    <div class="mx-auto w-96 bg-gray-50 relative">

        <div class="relative " x-data="{ shown: true, timeout: null }" x-init="@this.on('customer-created', () => {
            clearTimeout(timeout);
            shown = true;
            timeout = setTimeout(() => { shown = false }, 2000);
        })"
            x-show.transition.out.opacity.duration.1500ms="shown" x-transition:leave.opacity.duration.1500ms
            style="display: ;">
            <div class="absolute bottom-2 right-0 bg-gray-800 text-white  px-3 py-1 rounded-lg">
                {{ session('message') }}
            </div>
        </div>

        <div class="bg-white h-dvh flex flex-col relative">
            <div class="bg-blue-800 text-white p-2">
                <span>Anshu Medical Hall</span>
            </div>


            <div class="w-full p-2 flex gap-2">
                <input type="search" name="search" id="search" class="rounded p-1 border w-full "> <button
                    class="bg-sky-500 text-white px-3 rounded" type="submit">Search</button>
            </div>
            <div class="flex flex-col divide-y grow overflow-y-auto overflow-x-hidden">

                @foreach ($customers as $customer)
                    <div
                        class="overflow-hidden group/customer relative  w-full  min-h-14 border hover:bg-gray-50  transition-all duration-100 ">
                        <a class="relative  w-full rounded h-full flex gap-1"
                            href="{{ route('customer.transactions', $customer->id) }}" wire:navigate>
                            <div class="aspect-square h-full bg-white  p-1">
                                <div class="aspect-square h-full bg-white border rounded-full overflow-hidden">
                                    <img src="https://via.placeholder.com/52" alt="Square Image"
                                        class="object-cover w-full h-full">
                                </div>
                            </div>
                            <div class="flex-grow max-w-52 text-clip">
                                <div class="text-gray-700">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</div>
                                <div class="text-xs text-gray-500">{{ $customer->balance }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="w-full relative flex justify-end  bg-yellow-50 text-sm">
                <a href="{{ route('customer.create') }}" wire:navigate
                    class="absolute bottom-2 right-5 px-4 py-2 bg-red-700 text-white font-semibold rounded-3xl">Add
                    Customer</a>
            </div>




            <div
                class=" relative text-sm font-medium text-center text-gray-500 border-b border-t border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex gap-5 -mb-px justify-center">
                    <li class="grow">
                        <a href="#"
                            class="inline-block py-4 px-1 border-t-2 border-transparent  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Customer</a>
                    </li>
                    <li class="grow">
                        <a href="#"
                            class="inline-block py-4 px-1 text-blue-600 border-t-2 border-blue-600  active dark:text-blue-500 dark:border-blue-500"
                            aria-current="page">Bills</a>
                    </li>
                    <li class="grow">
                        <a href="#"
                            class="inline-block py-4 px-1 border-t-2 border-transparent  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Settings</a>
                    </li>

                </ul>
            </div>

            {{-- <livewire:customers.customers-modal /> --}}

        </div>
    </div>
</div>
