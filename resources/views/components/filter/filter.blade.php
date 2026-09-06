@props([
    'chips' => [],
])

<div {{ $attributes->merge(['class'=>"filter mt-3 mb-5 pb-5 pt-3 custom-scrollbar overflow-x-auto"]) }}>
    <form action="" method="GET" class="flex flex-row items-center gap-4 justify-start">
        <x-filter.search />

        @foreach ($chips as $chip)
            <x-filter.checkbox name="{{ $chip->name }}"/>
        @endforeach
    </form>
</div>
