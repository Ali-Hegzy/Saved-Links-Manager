<x-layout>
    <x-ui.card class="flex flex-col gap-3">
        <h1 class="text-5xl">Hello {{ $user->name }}</h1>
        <p>Mail : {{ $user->email }}</p>
        <div class="flex flex-row  flex-wrap gap-4 items-center ">
            <p>Sites : </p>
            @foreach ($sites as $site)
                <x-ui.card class="w-fit bg-bg-main">
                    {{ $site->name }}
                </x-ui.card>
            @endforeach
                <x-ui.card class="w-fit bg-bg-main cursor-pointer" id="add">
                    + Add
                </x-ui.card>
            @error('site')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <p>Number of Links you have : {{ $linksCount }} {{ Str::plural('Link',$linksCount) }}</p>
    </x-ui.card>
</x-layout>

<script>
    const add = document.getElementById('add');

    add.addEventListener('click', () => {
        if(!add.classList.contains('active')){
            add.classList.add('active');
            add.innerHTML = `
                <form method='POST' class="flex flex-row gap-1">
                    <input type='text' placeholder='Add site name' class="outline-none"/>
                    <input type="submit" class='cursor-pointer bg-primary px-2 rounded' name='site' value="Add"/>
                    <a class='cursor-pointer bg-red-600 px-2 rounded' id='close'> Close </a>
                </form>
            `;

            const close = document.getElementById('close');

            close.addEventListener('click', (e) => {
                e.stopPropagation();
                add.innerHTML = '+ Add';
                add.classList.toggle('active');
            });
        }
    });

</script>
