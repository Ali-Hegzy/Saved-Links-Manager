<x-layout>
    <x-form action='/register'>
        <x-form.header title="Register" description="Let's manage our link"/>

        <x-form.field name='name'/>

        <x-form.field name='email' type='email'/>

        <x-form.field name='password' type='password'/>

        <button class="p-2 bg-primary text-text-main rounded-2xl hover:bg-secondary transition hover:text-muted w-fit m-auto cursor-pointer">Register</button>
    </x-form>
</x-layout>
