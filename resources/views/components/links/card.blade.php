@props([
    'link'
])
<x-ui.card>
    <div class="upper flex flex-row justify-between">
        <h2 class="text-2xl line-clamp-1">{{ $link->title }}</h2>
        <x-ui.vKebabMenu>
            <ul class="flex flex-col gap-2">
                <li>
                    <form action="/link/{{ $link->id }}/delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="cursor-pointer">DELETE</button>
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
            <a href="/link/{{ $link->id }}" class="underline text-amber-500">View Link</a>
            <a href="{{ $link->url }}" target="_blank" class="underline text-red-500">Watch</a>
        </div>
    </div>
</x-ui.card>

