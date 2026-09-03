<x-layout>
    <x-ui.card class="text-center">
        <h1 class="text-5xl">{{ $inventory->name }}</h1>
        <p>{{ $inventory->description }}</p>
    </x-ui.card>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
    </div>
</x-layout>
