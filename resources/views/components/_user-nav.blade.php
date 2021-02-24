<div id="user-nav" class="flex border border-red-600 justify-end pr-2">
    <div id="user-nav" class="flex flex-col text-xs " style="width: 8rem;"><!-- hidden fixed top-0 right-0 px-6 py-4 sm:block -->
        <div class="flex flex-col text-white border border-green-400">
            <!-- Hericons chevron-down -->
                <button class="flex flex-row text-white" onclick="display_user_nav_items();">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-white"
                         viewBox="0 0 20 20" fill="white">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <div class="pt-1">Account</div>
                </button>
                <div id="user-nav-items" class="hidden">
                    <a href="#" class="text-xs underline">Profile</a>
                    <a href="#" class="underline">Log out</a>
                </div>
        </div>

    </div>

</div>
