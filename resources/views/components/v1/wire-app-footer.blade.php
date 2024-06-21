@props(['on'])

<div {{ $attributes->merge(['class' => 'text-sm text-gray-600 dark:text-gray-400']) }}>
    {{ $slot }}
</div>
