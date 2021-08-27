<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />


            <div class="block text-center bg-green-100">
                <div>Congratulations!</div>
                <div>
                    Your password has been reset.
                    Please click <a class="text-green-800" href="{{ route('welcome') }}">HERE</a> to log into TheDirectorsRoom.com!
                </div>
            </div>


    </x-jet-authentication-card>
</x-app-layout>
