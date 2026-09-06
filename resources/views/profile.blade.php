<x-layout>
    <x-ui.card class="flex flex-col gap-3">
        <h1 class="text-5xl">Hello {{ $user->name }}</h1>
        <p>Mail : {{ $user->email }}</p>
        <div class="flex flex-row  flex-wrap gap-4 items-center ">
            <p>Sites : </p>
            @foreach ($sites as $site)
                <x-ui.card class="w-fit bg-bg-main flex">
                    {{ $site->name }}
                </x-ui.card>
            @endforeach
                <a href="{{ route('sites.index') }}" class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted">View all</a>
        </div>
        <p>Number of Links you have : {{ $linksCount }} {{ Str::plural('Link',$linksCount) }}</p>
    </x-ui.card>
</x-layout>
