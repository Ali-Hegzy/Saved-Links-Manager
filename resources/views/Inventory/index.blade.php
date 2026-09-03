<x-layout>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($inventories as $inventory)
                <x-ui.card>
                    <div class="upper flex flex-row justify-between">
                        <h2 class="text-3xl">
                            {{ $inventory->name }}
                        </h2>
                        <x-ui.vKebabMenu>
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
                        </x-ui.vKebabMenu>
                    </div>
                    <p>{{ $inventory->description }}</p>
                </x-ui.card>
        @empty
            You don't have any inventory yet, <a href="{{ route('inventories.create') }}" class="text-primary underline"> Create one. </a>
        @endempty
    </div>
</x-layout>
