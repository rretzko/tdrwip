<div>
    <x-livewire-table-with-modal-forms >

        <x-slot name="title">
            {{ __('Library Information') }}
        </x-slot>

        <x-slot name="description">

            <x-sidebar-blurb blurb="Add or edit your library information here." />

        </x-slot>

        <x-slot name="table">

            {{-- error and success messages --}}
            @if($errors->any())
                <div style="border: 1px solid darkred; background-color: rgba(255,0,0,0.1); padding: 0.25rem; margin-bottom: 0.5rem;">
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                </div>
            @endif

            @if(session()->has('success'))
                <div style="border: 1px solid darkgreen; background-color: rgba(0,255,0,0.1); padding: 0.25rem; margin-bottom: 0.5rem;">
                    {{ session()->get('success') }}
                </div>
            @endif

            {{-- beginning of tailwindui table --}}
            <style>p{margin-bottom: 1rem;}</style>
            <div class="border border-gray-800 bg-gray-200 p-4">
                <p>
                    <b>Background</b>: I've been telling myself a story that Directors like you need a standardized
                    system for maintaining their Choral libraries.
                </p>
                <p>In my head, you (or your student librarians) would be able to input your choral literature and then
                    <b><i>quickly</i></b> and <b><i>easily</i></b> search that library by any criteria necessary.
                </p>
                <p>
                    <ol class="ml-8" style="list-style-type: disc">
                        <li>Maybe you're trying to remember what music you performed five year ago ... by ensemble ... in the
                            Spring concert.</li>
                        <li>Or maybe you're looking for pieces you have by Jim Papoulis, or Emily Crocker, or John Rutter.</li>
                        <li>Or maybe you're looking for an a cappella Winter SSA piece.</li>
                    </ol>
                </p>
                <p>
                    My story is that it would be helpful to <b><i>quickly</i></b> and <b><i>easily</i></b>
                    find these pieces in your library: Open a page, tic some checkboxes, select some options and
                    <b><i>Voila! Here's what's in your library!</i></b>
                </p>
                <p>
                    If you agree, would you take 45 seconds to tell me what's important for you to have at your fingertips?
                    <form method="post" action="{{ route('library.questionnaire') }}">
                    @csrf
                    <div class="flex flex-row">
                        <div id="input">
                            <style>
                                input{margin-top: 0.25rem;}
                                label{margin-left: 0.5rem;}
                                .hint{font-size: 0.66rem;}
                            </style>
                            <header class="italic">"To work for me, the library has to contain...":</header>
                            <div class="ml-6">
                                <div class="flex flex-row">
                                    <input type="checkbox" name="title" value="1"
                                        @if(old('title') || $questionnaire->title) checked @endif
                                    />
                                    <label for="title">Title</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="subtitle" value="1"
                                           @if(old('subtitle') || $questionnaire->subtitle) checked @endif
                                    />
                                    <label for="subtitle">SubTitle</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="composer" value="1"
                                           @if(old('composer') || $questionnaire->composer) checked @endif
                                    />
                                    <label for="composer">Composer(s)</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="arranger" value="1"
                                           @if(old('arranger') || $questionnaire->arranger) checked @endif
                                    />
                                    <label for="arranger">Arranger(s)</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="publisher" value="1"
                                           @if(old('publisher') || $questionnaire->publisher) checked @endif
                                    />
                                    <label for="publisher">Publisher</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="arrangement" value="1"
                                           @if(old('arrangement') || $questionnaire->arrangement) checked @endif
                                    />
                                    <label for="arranger">Arrangement <span class="hint">(SATB, SSA, etc.)</span></label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="accompaniment" value="1"
                                           @if(old('accompaniment') || $questionnaire->accompaniment) checked @endif
                                    />
                                    <label for="accompaniment">Accompaniment <span class="hint">(none, piano, harp, etc.)</span></label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="language" value="1"
                                           @if(old('language') || $questionnaire->language) checked @endif
                                    />
                                    <label for="language">Language</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="tempo" value="1"
                                           @if(old('tempo') || $questionnaire->tempo) checked @endif
                                    />
                                    <label for="tempo">Tempo <span class="hint">(meter markings or words)</span></label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="year" value="1"
                                           @if(old('year') || $questionnaire->year) checked @endif
                                    />
                                    <label for="year">Year Performed</label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="ensemble" value="1"
                                           @if(old('ensemble') || $questionnaire->ensemble) checked @endif
                                    />
                                    <label for="ensemble">Performed By <span class="hint">(ex. Ensemble name)</span></label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="concert" value="1"
                                           @if(old('concert') || $questionnaire->concert) checked @endif
                                    />
                                    <label for="concert">Performed At <span class="hint">(ex. Spring Concert, Graduation, etc.)</span></label>
                                </div>
                                <div class="flex flex-row">
                                    <input type="checkbox" name="comments" value="1"
                                           @if(old('comments') || $questionnaire->comments) checked @endif
                                    />
                                    <label for="comments">Comments <span class="hint">(Free form comments)</span></label>
                                </div>
                                <div>
                                    <textarea cols="40" name="must_haves" placeholder="Other items the library MUST have...">{{ (old('must_haves') ?: ($questionnaire->must_haves ?: '')) }}</textarea>
                                </div>
                                <div>
                                    <textarea cols="40" name="nice_haves" placeholder="Other items that would be OPTIONAL or nice to have...">{{ (old('nice_haves') ?: ($questionnaire->nice_haves ?: '')) }}</textarea>
                                </div>
                                <div>
                                    <label>
                                        If the library met your needs, would you be willing to pay a
                                        fee of $6.71/month or $60/year to help me continue to build for you?
                                        <span class="hint">($6.71 is the price of a famous breakfast
                                            sandwich and medium coffee...)</span>
                                    </label>
                                    <div>
                                        <input style="margin-top: -0.25rem;" type="radio" name="fee" value="1" {{ ((old('fee') && (old('fee') == 1)) || ($questionnaire->fee == 1)) ? 'checked' : '' }}>
                                        <label>Yes</label>
                                    </div>
                                    <div>
                                        <input style="margin-top: -0.25rem;" type="radio" name="fee" value="0" {{ ((old('fee') && (old('fee') == 0)) || ($questionnaire->fee == 0)) ? 'checked' : '' }}>
                                        <label>No</label>
                                    </div>
                                </div>
                                <div>
                                    <input class="bg-black text-white p-2 rounded-full shadow-lg" type="submit" name="submit" value="Thank You!" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </p>
            </div>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">
                    <div class="space-y-4 overflow-hidden border-b border-gray-200 sm:rounded-lg">




                    </div>
                </div>
            </div>

        </x-slot>


    </x-livewire-table-with-modal-forms>
</div>
