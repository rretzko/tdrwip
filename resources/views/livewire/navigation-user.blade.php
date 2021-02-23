<div wire:model="navigation-user" id="user-nav" class="flex justify-end pr-2 h-20">
    <div id="user-nav" class="flex flex-col text-xs " style="width: 8rem;"><!-- hidden fixed top-0 right-0 px-6 py-4 sm:block -->
        <div class="flex flex-col text-white ">

            <button wire:click="toggleItems()" class="flex flex-row text-white outline-none focus:outline-none">
                @if($navigation_user)
                    <!-- Hericons chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-gray-300"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                @else
                    <!-- Hericons chevron-down -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-gray-300"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @endif
                <div class="pt-1 text-gray-300">Account</div>
            </button>
            <div id="user-nav-items" class="@if(! $navigation_user) hidden @endif flex flex-col ml-8 px-2 py-1"
                 style="background-color: rgba(255,255,255, .1);"
            >
                <a href="{{ route('profile.show') }}" class="">Profile</a>
                <a href="mailto:rick@mfrholdings.com?subject=TDR Support&body=Hey Rick, I've got a question: " class="">Support</a>
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>

    </div>

</div>


