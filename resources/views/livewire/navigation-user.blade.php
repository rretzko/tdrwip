<div wire:model="navigation-user" class="flex flex-row justify-end pr-8" x-data="{false}">

    <div class="flex flex-col w-4/12 sm:w-2/12 lg:w-1/12">
        <button  wire:click="toggleItems()"
                 class=" focus:outline-none shadow cursor-pointer text-white hover:text-yellow "
                 style="width: 4rem;"
        >
            <div class="flex flex-row text-white">
                <!-- Hericons chevron-down -->
                @if($navigation_user)
                    <!-- Hericons chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-white"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                @else
                    <!-- Hericons chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6 text-white"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    @endif
                {{ auth()->user()->username }}
            </div>
        </button>

        <ul
            x-show="@if($navigation_user) true @else false @endif"
            class="w-10/12 my-2 ml-4 shadow rounded w-40 py-1 pl-2 bg-white bg-opacity-10 text-sm"
            x-transition:enter="transition-transform transition-opacity ease-out duration-600"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-end="opacity-0 transform -translate-y-3"
        >
            <li>
                <a href="{{ route('profile.show') }}" >Profile</a>
            </li>
            <li>
                <a href="mailto:rick@mfrholdings.com?subject=TDR Support&body=Hey Rick, I've got a question: " >Support</a>
            </li>
            <li> <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </li>
        </ul>
    </div>

</div>
<!-- {{--
<div wire:model="navigation-user" id="user-nav" class="flex justify-end pr-2 h-20 ">
    <div id="user-nav" class="flex flex-col text-xs w-24" style="">
        <div class="flex flex-col text-white">

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
            <div id="user-nav-items" class="@if(! $navigation_user) hidden @endif flex flex-col ml-8 px-2 py-1 "
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
--}} -->

