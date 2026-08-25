@props([
    'name'
])
<label class="checkbox ">
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" class="hidden peer"/>
    <span class="bg-bg-card p-2 rounded-full cursor-pointer hover:bg-secondary-light peer-checked:bg-primary shadow-primary shadow-md transition">{{ $name }}</span>
</label>
