<!-- resources/views/components/input.blade.php -->
<div>
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        autocomplete="{{ $name }}" placeholder="{{ $placeholder }}" wire:model="{{ $model }}"
        class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
    <div class="h-4">
        @error($name)
            <div class="text-red-600 text-xs">{{ $message }}</div>
        @enderror
    </div>
</div>
