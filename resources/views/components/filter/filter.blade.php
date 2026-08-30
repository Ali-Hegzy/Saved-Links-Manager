@props([
    'sites',
])

<div class="filter mt-3 mb-5 pb-5 pt-3 custom-scrollbar overflow-x-auto">
    <form action="" method="GET" class="flex flex-row items-center gap-4 justify-start">
        <x-filter.search />

        @foreach ($sites as $site)
            <x-filter.checkbox name="{{ $site->name }}"/>
        @endforeach

        <button type="submit" class="p-2 rounded-full cursor-pointer hover:bg-primary-dimmed bg-primary transition">Filter</button>
    </form>
</div>
