@props([
    'link',
    'inventories' => [],
    'currentInv' => [],
])
<x-ui.card>
    <div class="upper flex flex-row justify-between">
        <h2 class="text-2xl line-clamp-1">{{ $link->title }}</h2>
        <x-ui.vKebabMenu>
            <ul class="flex flex-col gap-2">
                <li x-data="{ open: false }"> {{-- This <li> is AI Generated --}}
                    <button type="button" @click="open = true" class="cursor-pointer">Add To</button>
                    <div
                        x-cloak
                        x-show="open"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div
                            x-show="open"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                            @click="open = false"
                        ></div>
                        <div
                            x-show="open"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            @keydown.escape.window="open = false"
                            class="relative w-full max-w-md z-10"
                        >
                            <x-ui.card class="bg-bg-main shadow-xl">
                                <div class="flex justify-end">
                                    <button type="button" @click="open = false" class="text-gray-400 hover:text-white cursor-pointer">&times;</button>
                                </div>
                                <div class="p-2">
                                    <h3 class="text-lg font-bold mb-4">Add to inventory</h3>
                                    <div class="flex gap-2 flex-col">
                                    @forelse ($inventories as $inventory)

                                        <form action="{{ route('inventoryItems.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="item" value="{{ $link->id }}"/>
                                            <input type="hidden" name="inventory" value="{{ $inventory->id }}"/>
                                            <button class="min-w-full cursor-pointer">
                                                <x-ui.card >
                                                    {{ $inventory->name }}
                                                </x-ui.card>
                                            </button>
                                        </form>
                                    @empty
                                        <p>You don't have any inventories yet.</p>
                                    @endforelse
                                    </div>
                                </div>
                            </x-ui.card>
                        </div>
                    </div>
                </li>
                @if ($currentInv)
                    <li>
                        <form action="{{ route('inventoryItems.destroy') }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="item" value="{{ $link->id }}"/>
                            <input type="hidden" name="inventory" value="{{ $currentInv->id }}"/>
                            <button class="cursor-pointer">Remove from {{ $currentInv->name }}</button>
                        </form>
                    </li>
                @endif
                <li>
                    <form action="{{ route('links.destroy', $link) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="cursor-pointer">DELETE Link</button>
                    </form>
                </li>
            </ul>
        </x-ui.vKebabMenu>
    </div>
    <p class="line-clamp-1">{{ $link->description }}</p>
    <p>Site : {{ $link->site }}</p>
    <div class="flex justify-between">
        <p>Watched : {{ $link->status ? 'Yes' : 'No' }}</p>
        <div class="links">
            <a href="{{ route('links.show', $link) }}" class="underline text-amber-500">View Link</a>
            <a href="{{ $link->url }}" target="_blank" class="underline text-red-500">Watch</a>
        </div>
    </div>
</x-ui.card>

