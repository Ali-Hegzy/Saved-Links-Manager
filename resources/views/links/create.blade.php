<x-layout>
    <x-form action='/links/create'>
        <x-form.header title="Create a link" description="Create a saved link to watch it again"/>

        <x-form.field name='title'/>

        <x-form.textarea name='description' />

        <x-form.field name='url' />

        <x-form.field name='site' />

        <input type="hidden" id="status" name="status" value="0"/>

        <div class='flex gap-1.5'>
        <input
            type="checkbox"
            id="status"
            name="status"
            value="1"
            @checked(old('status'))
            /><label>Watched</label>
        </div>

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Create</button>
    </x-form>
</x-layout>
