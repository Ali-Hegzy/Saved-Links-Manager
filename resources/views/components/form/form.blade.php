@props([
    'action' => '',
    'method' => 'POST',
    'advMethod' => '',
    ])

<form
    action="{{ $action }}"
    method="{{ $method }}"
    {{ $attributes->merge([
        'class' => 'max-w-2xl mx-auto pt-9 gap-5 flex flex-col'
    ]) }}
    >
    @if ($advMethod)
        @method($advMethod)
    @endif
    @csrf

    {{ $slot }}

</form>
