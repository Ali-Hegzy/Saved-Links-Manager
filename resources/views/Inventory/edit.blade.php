<x-layout>
    <x-form action='{{ route("inventories.update", $inventory) }}' advMethod='PUT'>
        <x-form.header title="Edit the Inventory" description="Edit the inventory to fix errors"/>

        <x-form.field name='name' value='{{ $inventory->name }}'/>

        <x-form.textarea name='description' value='{{ $inventory->description }}'/>

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Update</button>
    </x-form>
</x-layout>
