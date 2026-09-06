<x-layout>
    <div class="flex justify-center">
        <x-ui.card class="w-fit cursor-pointer" id="add">
            <form method='POST' action="{{ route('sites.update', $site) }}" class="flex flex-row gap-1">
                @csrf
                @method('PUT')
                <input type='text' placeholder='Edit the site' name='name' class="outline-none" value="{{ $site->name }}"/>
                <input type="submit" class='cursor-pointer bg-primary px-2 rounded' value="Edit"/>
            </form>
        </x-ui.card>
        @error('name')
            <p class="text-red-600">{{ $message }}</p>
        @enderror
    </div>
</x-layout>
