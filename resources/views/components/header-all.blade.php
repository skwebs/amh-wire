<x-header>

    <x-header.item class="aspect-square">
        @isset($back)
            <a class="aspect-square h-full flex justify-center items-center hover:bg-black/20" href="{{ $href }}"
                wire:navigate>
                <x-icons.left-arrow />
            </a>
            @endif
        </x-header.item>
        <x-header.item>
            {{-- Customers List --}}
            {{ $slot }}
        </x-header.item>
        <x-header.item>
            <div class="hover:bg-black/20 p-1 rounded-full me-1">
                <x-icons.ellipsis-vertical />
            </div>
        </x-header.item>
    </x-header>
