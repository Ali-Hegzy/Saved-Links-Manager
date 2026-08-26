@props([
    'action' => '',
    'method' => 'POST'
    ])

<form
    action="{{ $action }}"
    method="{{ $method }}"
    {{ $attributes->merge([
        'class' => 'max-w-2xl mx-auto pt-9 gap-5 flex flex-col'
    ]) }}
    >
    @csrf

    {{ $slot }}

</form>
