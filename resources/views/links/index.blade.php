<x-layout>
    <x-filter :sites="$sites"/>

    <div class="cards grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($links as $link)
        <x-links.card :link="$link" />
    @empty
        There is no links <a href="{{ route('links.create') }}" class="text-primary underline">Create One</a>
    @endempty
    </div>
</x-layout>
