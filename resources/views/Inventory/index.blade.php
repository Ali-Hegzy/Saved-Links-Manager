<x-layout>
    <div class="flex items-center flex-col md:flex-row-reverse py-2 gap-3 justify-between">
        <a href="{{ route('inventories.create') }}" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">Create an Inventory</a>

        <x-filter class="m-0! p-0!" />
    </div>
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
            You don't have any inventory yet. </a>
        @endempty
    </div>
</x-layout>
