<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="">
            @csrf

            <div class="block text-center bg-green-100">
                <div>Congratulations!</div>
                <div>
                    Your password has been reset.
                    Please use the <a class="text-green-700" href="{{ route('login') }}">log in link</a> above to log into TheDirectorsRoom.com!
                </div>
            </div>

        </form>
    </x-jet-authentication-card>
</x-app-layout>
