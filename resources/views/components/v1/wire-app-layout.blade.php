<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div class="mx-auto w-96 bg-gray-50 relative">

        @props(['heading', 'footer', 'href'])

        <div {{ $attributes->class(['h-svh w-full flex flex-col']) }}>
            {{-- <div {{ $heading->attributes->class(['']) }}>
                {{ $heading }}
            </div> --}}
            <header class="bg-blue-700 text-white m-0 p-0 flex justify-between">
                <div class="h-12 aspect-square">
                    <x-back-arrow-link href="{{ $href }}" />
                </div>
                {{ $heading }}
                <div class="h-12 aspect-square">

                </div>
            </header>

            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer {{ $footer->attributes->class(['text-gray-700']) }}>
                {{ $footer }}
            </footer>
        </div>
    </div>
</body>

</html>
