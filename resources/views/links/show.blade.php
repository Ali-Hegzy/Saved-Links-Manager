<x-layout>
    <x-ui.card class="box mt-8 flex flex-col gap-4">
        <h1 class="text-5xl">{{ $link->title }}</h1>
        <p class="text-gray-300">{{ $link->description }}</p>
        <p>Site : {{ $link->site }}</p>
        <p>
            Full URL :
            <a href="{{ $link->url }}" target="_blank" class="text-red-500 underline">{{ $link->url }}</a>
        </p>
        <p>Status : {{ $link->status ? "Watched" : "Not watched" }}</p>
        <div class="options flex flex-row gap-5">
            <p>Options: </p>
            <div class="buttons flex flex-row">
                <a href="{{ route('links.edit', $link) }}" target="_blank" class="text-amber-500 underline">Edit</a>
            </div>
        </div>
    </x-ui.card>
</x-layout>
