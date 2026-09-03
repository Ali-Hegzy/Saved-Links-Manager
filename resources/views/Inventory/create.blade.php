<x-layout>
    <x-form action='{{ route("inventories.store") }}'>
        <x-form.header title="Create a Inventory" description="Create a Inventory to collect similar links in one place"/>

        <x-form.field name='name'/>

        <x-form.textarea name='description' />

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Create</button>
    </x-form>
</x-layout>
