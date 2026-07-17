<x-layout>
    <x-form action='/login'>
        <x-form.header title="Login" description="Glad to see you manage again."/>

        <x-form.field name='email' type='email'/>

        <x-form.field name='password' type='password'/>

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Login</button>
    </x-form>
</x-layout>
