<nav class="border-b border-muted px-6 py-2 mb-2">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <div class="text-3xl">
            <a href="/">Links</a>
        </div>

        <div class="flex items-center gap-2">
            @guest
                <a href="/" class="p-2">Login</a>
                <a href="/" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Register</a>
            @endguest
            @auth
                <a href="/">Logout</a> <!-- Temp tag, of course logout will be a form not an anchor tag -->
            @endauth
        </div>
    </div>
</nav>
