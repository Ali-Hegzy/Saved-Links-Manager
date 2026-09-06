<x-layout>
    <div class="flex items-center flex-col md:flex-row-reverse py-2 gap-3 justify-between">
        <x-ui.card class="w-fit bg-bg-main cursor-pointer" id="add">
            <form method='POST' action="{{ route('sites.store') }}" class="flex flex-row gap-1">
                @csrf
                <input type='text' placeholder='Add a new site' name='name' class="outline-none"/>
                <input type="submit" class='cursor-pointer bg-primary px-2 rounded' value="Add"/>
            </form>
        </x-ui.card>

        <x-filter class="m-0! p-0!"/>
    </div>

    <x-ui.card>
        <div class="flex flex-wrap gap-2">
            @forelse ($sites as $site)
            <x-ui.card class="w-fit bg-bg-main flex justify-between gap-2">
                {{ $site->name }}
                <x-ui.vKebabMenu>
                    <ul class="flex flex-col gap-2">
                        <li>
                            <a href="{{ route('sites.edit', $site) }}">Edit</a>
                        </li>
                        <li>
                            <form action="{{ route('sites.destroy', $site) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="cursor-pointer">DELETE</button>
                            </form>
                        </li>
                    </ul>
                </x-ui.vKebabMenu>
            </x-ui.card>
            @empty
                <p>You don't have any sites</p>
            @endforelse
        </div>
    </x-ui.card>
</x-layout>
