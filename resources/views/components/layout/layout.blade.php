@props([
    'title' => 'Saved Links Manager'
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title }}</title>
</head>
<body class="bg-bg-main text-text-main">
    <x-layout.nav />
    <main class="max-w-7xl mx-auto px-6">
        {{ $slot }}
        @session('invMessage')
            {{-- From laracasts --}}
            <div
                    x-data = "{show : true}"
                    x-init = "setTimeout(() => show = false, 3000)"
                    x-show = "show"
                    x-transition.opacity.duration.300ms
                    class="bg-primary px-4 py-3 absolute bottom-4 right-4 rounded-lg"
                >
                    {{ $value }}
                </div>
        @endsession
    </main>
</body>
</html>
