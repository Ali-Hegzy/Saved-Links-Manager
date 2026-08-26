@props([
    'name',
    'value' => '',
])

<div class='flex flex-col gap-1.5'>
    <label class='pl-2' for='{{ $name }}'>{{ ucfirst($name) }}</label>
    <textarea
        id='{{ $name }}'
        name='{{ $name }}'
        class='outline-none p-1 pl-2 bg-primary-dimmed rounded-xl hover:bg-primary focus:bg-primary transition hover:text-text-main focus:text-text-main text-muted'
        >{{old($name, $value)}}</textarea>

    @error($name)
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>
