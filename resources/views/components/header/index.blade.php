<header {{ $attributes->merge(['class' => 'bg-blue-600 text-white flex justify-between h-10']) }}>
    {{-- {{ $slot->isEmpty() ? 'Header is empty.' : $slot }} --}}
    {{ $slot }}
</header>
