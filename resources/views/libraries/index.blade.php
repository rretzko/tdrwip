<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->

    <div id="early-access" class="bg-white m-auto border  w-11/12 rounded mb-1">
        <div class="bg-gray-100 border border-black rounded m-2 p-2">
            <p>
                As thanks for responding to our survey, you have "Early Access" to
                the Library module while we build it out.
            </p>
            <p>
                During this period, we are providing a 'Comments' box at the bottom of every page of the module for you
                to provide feedback, questions, etc.  Please don't hesitate to let us know your thoughts!
            </p>
        </div>
    </div>


    <div id="footer" class="bg-white m-auto border w-11/12 rounded">
        <form method="post" action="{{ route('library.comments',['page' => Route::currentRouteName()]) }}" class="m-1 flex flex-col space-y-1">
            @csrf
            <textarea name="comments" placeholder="Questions, Comments, Concerns..." class="w-11/12"></textarea>
            <input type="submit" name="submit" value="Submit" class="w-1/12 bg-black text-white rounded-full" >
            @if(session()->has('thanks'))
                <span style="background-color: rgba(0,255,0,0.1); padding: 0 0.5rem; max-width: 20rem;" class="rounded">
                    {{ session()->get('thanks') }}
                </span>
            @endif
        </form>
    </div>

</x-app-layout>
