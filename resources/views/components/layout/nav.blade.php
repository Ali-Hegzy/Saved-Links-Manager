<nav class="border-b border-muted px-6 py-2 mb-2">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <div class="text-3xl">
            <a href="/">Logo</a>
        </div>

        @auth
            <div class="middle flex items-center gap-4">
                <a href="/links" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Links</a>
                <a href="/links/create" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Create</a>
            </div>
        @endauth

        <div class="end flex items-center gap-2">
            @guest
                <a href="/login" class="p-2">Login</a>
                <a href="/register" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Register</a>
            @endguest
            @auth
                <div x-data="{ open: false }" class="relative flex">
                    <button @click="open = ! open" class="cursor-pointer">
                        {{-- This SVG is AI Generated --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                            <defs>
                                <!-- Modern blue gradient -->
                                <linearGradient id="userGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#4F46E5" />
                                <stop offset="100%" stop-color="#06B6D4" />
                                </linearGradient>

                                <!-- Clip path to keep the avatar body within the circular boundary -->
                                <clipPath id="circleClip">
                                <circle cx="50" cy="50" r="45" />
                                </clipPath>
                            </defs>

                            <!-- Background circle -->
                            <circle cx="50" cy="50" r="46" fill="#F3F4F6" stroke="#E5E7EB" stroke-width="2" />

                            <!-- User avatar elements clipped inside the circle -->
                            <g clip-path="url(#circleClip)">
                                <!-- Head -->
                                <circle cx="50" cy="40" r="16" fill="url(#userGrad)" />

                                <!-- Body / Shoulders -->
                                <path d="M22 84 C22 66, 35 62, 50 62 C65 62, 78 66, 78 84 Z" fill="url(#userGrad)" />
                            </g>

                            <!-- Subtle outer border accent -->
                            <circle cx="50" cy="50" r="46" fill="none" stroke="url(#userGrad)" stroke-width="2" stroke-opacity="0.3" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" @click.outside="open = false">
                        <x-ui.card class="absolute right-0 top-10">
                            <ul class="p-2 flex flex-col gap-2">
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/inventories">Inventories</a></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="cursor-pointer">LogOut</button>
                                    </form>
                                </li>
                            </ul>
                        </x-ui.card>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
