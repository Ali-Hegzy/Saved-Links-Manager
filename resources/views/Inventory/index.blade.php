<x-layout>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($inventories as $inventory)
                <x-ui.card>
                    <div class="upper flex flex-row justify-between">
                        <h2 class="text-3xl">
                            {{ $inventory->name }}
                        </h2>
                        <div x-data="{ open: false }" class="relative flex">
                            <button @click="open = ! open" class="cursor-pointer">
                                {{-- This SVG is AI Generated --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                    <!-- Top Dot -->
                                    <circle cx="12" cy="5" r="2" />
                                    <!-- Center Dot -->
                                    <circle cx="12" cy="12" r="2" />
                                    <!-- Bottom Dot -->
                                    <circle cx="12" cy="19" r="2" />
                                </svg>
                            </button>

                            <div x-cloak x-show="open" @click.outside="open = false">
                                <x-ui.card class="absolute right-0 top-8 bg-bg-main">
                                    <ul class="flex flex-col gap-2">
                                        <li>
                                            <a href="{{ route('inventories.show', $inventory) }}">
                                                View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('inventories.edit', $inventory) }}">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('inventories.destroy', $inventory) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="cursor-pointer">DELETE</button>
                                            </form>
                                        </li>
                                    </ul>
                                </x-ui.card>
                            </div>

                        </div>
                    </div>
                    <p>{{ $inventory->description }}</p>
                </x-ui.card>
        @empty
            You don't have any inventory yet, <a href="{{ route('inventories.create') }}" class="text-primary underline"> Create one. </a>
        @endempty
    </div>
</x-layout>
