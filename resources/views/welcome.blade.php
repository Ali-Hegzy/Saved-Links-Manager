<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Saved Links Manager</title>
</head>
<body class="md:bg-linear-to-b from-primary bg-bg-main text-text-main">
    <main class="max-w-7xl mx-auto md:px-6">
        <div class="md:border-x md:mx-10 border-primary-dimmed px-5 bg-bg-main bg-grid">
            <div class="flex flex-col justify-center items-center gap-5 text-center h-dvh">
            <h1 class="text-7xl md:text-8xl">Links Manager</h1>
            <p class="text-muted">A web site to manage your saved links from any site you want Youtube, LinkedIn, Facebook, ...etc</p>
            <div class="flex gap-3">
                @guest
                    <a href="/login" class="p-2 text-xl border border-secondary-light bg-secondary text-text-muted hover:border-primary hover:shadow-primary hover:shadow-l rounded-xl transition">Login</a>
                    <a href="/register" class="p-2 text-xl border border-secondary-light bg-secondary text-text-muted hover:border-primary hover:shadow-primary hover:shadow-l rounded-xl transition">Register</a>
                @endguest
                @auth
                    <a href="/links" class="p-2 text-xl border border-secondary-light bg-secondary text-text-muted hover:border-primary hover:shadow-primary hover:shadow-l rounded-xl transition">See Your Links</a>
                @endauth
            </div>
        </div>
    </div>
    </main>
</body>
</html>
