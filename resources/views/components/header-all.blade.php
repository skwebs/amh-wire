<x-header {{ $attributes->merge(['class' => '']) }}>

    <x-header.item class="aspect-square">

        @if (isset($href) && !empty($href))
            <a class="aspect-square h-full flex justify-center items-center hover:bg-black/20" href="{{ $href }}"
                wire:navigate>
                <x-icons.left-arrow />
            </a>
        @endif

    </x-header.item>
    <x-header.item>
        {{ $slot }}
    </x-header.item>
    <x-header.item>
        {{-- <div x-data="{ isOpen: false }" class="relative">
            <div class="flex hover:bg-black/20 aspect-square p-1 rounded-full me-1">
                <button type="button" @click="isOpen = !isOpen">
                    <x-icons.ellipsis-vertical />
                </button>
            </div>
            <div x-show="isOpen" @click.outside="isOpen = false"
            x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 z-10 mt-2 me-2  origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <livewire:v1.auth.logout>
                </div>
        </div> --}}

    </x-header.item>
</x-header>
