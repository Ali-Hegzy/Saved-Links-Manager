<x-layout>
    @forelse($links as $link)

    @empty
        There is no links <a href="/links/create" class="text-primary underline">Create One</a>
    @endempty
</x-layout>
