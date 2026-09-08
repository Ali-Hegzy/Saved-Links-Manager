@if(session()->hasAny([
    'invMessage', 'loggedIn', 'loggedOut', 'registerd', 'link.store', 'link.update', 'link.destroy', 'site.store', 'site.update', 'site.destroy', 'inventory.store', 'inventory.update', 'inventory.destroy',
    ]))
    {{-- From laracasts --}}
    <div
            x-data = "{show : true}"
            x-init = "setTimeout(() => show = false, 3000)"
            x-show = "show"
            x-transition.opacity.duration.300ms
            class="bg-primary px-4 py-3 absolute bottom-4 right-4 rounded-lg"
        >
            {{ session('invMessage') ?? session('loggedIn') ?? session('loggedOut') ??  session('registerd') ?? session('link.store') ?? session('link.update') ?? session('link.destroy') ?? session('site.update') ?? session('site.store') ?? session('site.destroy') ?? session('inventory.store') ?? session('inventory.update') ?? session('inventory.destroy') }}
        </div>
@endif
