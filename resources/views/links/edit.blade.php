<x-layout>
    <x-form advMethod='PUT' action='{{ route("links.update", $link) }}'>
        <x-form.header title="Edit Link" description="Edit the link to fix errors"/>

        <x-form.field name='title' value="{{ $link->title }}"/>

        <x-form.textarea name='description' value="{{ $link->description }}" />

        <x-form.field name='url' value="{{ $link->url }}"/>

        <x-form.selectionList name='site' :items="$sites"/>

        <input type="hidden" id="status" name="status" value="0"/>

        <div class='flex gap-1.5'>
        <input
            type="checkbox"
            id="status"
            name="status"
            value="1"
            @checked(old('status',$link->status))
            /><label>Watched</label>
        </div>

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Update</button>
    </x-form>
</x-layout>
