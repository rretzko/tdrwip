<div id="guest-nav"><!-- relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0 -->
    @if (Route::has('login'))
        <div id="guest-nav" class="text-xs"><!-- hidden fixed top-0 right-0 px-6 py-4 sm:block -->
            <div id="guest-modules">
                <a href="{{ url('/dashboard') }}" class="text-xs underline">Dashboard</a>
            </div>
            <div id="login-register">
                <a href="{{ route('login') }}" class="underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-1 underline">Register</a>
                @endif
            </div>
        </div>
    @endif
</div>
