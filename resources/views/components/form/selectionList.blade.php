@props([
    'label' => '',
    'name',
    'items'
])

<div class="flex flex-col gap-1.5">
    <label for="{{ $name }}" class="pl-2">{{$label === '' ? "Choose the $name :" : $label}}</label>
    <select id="{{ $name }}" name="{{ $name }}" class=" outline-none p-1 px-2 bg-primary-dimmed rounded-xl hover:bg-primary focus:bg-primary transition hover:text-text-main focus:text-text-main text-muted">
        @foreach ($items as $item)
            <option value="{{ $item->name }}" @selected(old($name) === $item->name) >{{ $item->name }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>
