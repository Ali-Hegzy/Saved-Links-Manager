<nav class="border-b border-muted px-6 py-2 mb-2">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <div class="text-3xl">
            <a href="/">Links</a>
        </div>

        <div class="flex items-center gap-2">
            @guest
                <a href="/login" class="p-2">Login</a>
                <a href="/register" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Register</a>
            @endguest
            @auth
                <form action="/logout" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="p-2 bg-red-800 text-text-main rounded-2xl hover:bg-red-900 transition hover:text-muted cursor-pointer">LogOut</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
