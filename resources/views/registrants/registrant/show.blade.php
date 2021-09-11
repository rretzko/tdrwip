<x-app-layout><!-- app/view/components/AppLayout.php calling resources/views/layouts/app.blade.php -->
    <style>.hint {
            font-size: .8rem;
        }</style>
    <div>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div>

                <x-livewire-table-with-modal-forms>

                    <x-slot name="title">
                        {{ __('Registrant Information') }}
                    </x-slot>

                    <x-slot name="description">

                        <x-sidebar-blurb
                            blurb="{{ $registrant->student->person->fullName }} registration information for: {{ $eventversion->name }}"/>

                        <x-sidebar-blurb
                            blurb="The following details may be helpful for {{ $eventversion->name }} and can be updated on the <a href='{{ route('students.index') }}' class='text-yellow-200'>student's record</a>:<ul class='ml-8 list-disc'>
<li>Grade/Class</li>
<li>Preferred Pronoun</li>
<li>Height</li>
<li>Shirt size</li>
</ul>"
                        />

                    </x-slot>

                    <x-slot name="table">

                        {{-- BACK TO ROSTER --}}
                        <div class="flex text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 20 20"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <a href="{{ route('registrants.index',['eventversion' => $eventversion]) }}"
                               class="text-red-700 ml-2 pb-4">
                                Return to Registrant Roster
                            </a>
                        </div>

                        {{-- REGISTRANT FORM --}}
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
                            <div class="py-2 align-middle inline-block min-w sm:px-6 lg:px-8">

                                <div class="border border-black text-center font-bold {{ $registrant->registranttypedescrbackground }} ">
                                    Registrant status: {{ $registrant->registranttypedescr }}
                                </div>

                                <div class="space-y-4 overflow-hidden border-b border-gray-200 sm:rounded-lg">

                                    <form class="px-2" method="post"
                                          @if(config('app.url') === 'http://localhost')
                                            action="{{ route('registrant.update', ['registrant' => $registrant]) }}">
                                          @else
                                            action="https://thedirectorsroom.com/registrant/update/{{ $registrant->id }}">
                                          @endif

                                        @csrf

                                        {{-- GRADE/CLASS ADVISORY --}}
                                        <x-inputs.group label="Grade/Class" for="" borderless="true" paddingless="true">

                                            <div class="mt-2">
                                                {{ $registrant->student->gradeClassof }}
                                            </div>

                                        </x-inputs.group>

                                        {{-- PRONOUN ADVISORY --}}
                                        <x-inputs.group label="Preferred Pronoun" for="" borderless="true"
                                                        paddingless="true">

                                            <div class="mt-2">
                                                {{ $registrant->student->person->pronoun->descr }}
                                            </div>

                                        </x-inputs.group>

                                        {{-- HEIGHT ADVISORY --}}
                                        <x-inputs.group label="Height" for="" borderless="true"
                                                        paddingless="true">

                                            <div class="mt-2">
                                                {{ $registrant->student->heightFootInch }}
                                            </div>

                                        </x-inputs.group>

                                        {{-- SHIRT SIZE ADVISORY --}}
                                        <x-inputs.group label="Shirt Size" for="" borderless="true"
                                                        paddingless="true">

                                            <div class="mt-2">
                                                {{ $registrant->student->shirtsize->descr }}
                                            </div>

                                        </x-inputs.group>

                                        {{-- PROGRAM NAME --}}
                                        <x-inputs.group x-data x-init="$refs.programname.focus()" label="Program name"
                                                        for="programname"
                                                        borderless="true" paddingless="true"
                                        >

                                            <x-inputs.text label="" x-ref="programname" for="programname" placeholder=""
                                                           currentvalue="{{ $registrant->programname === 'Programname'
                                                            ? $registrant->student->person->fullName
                                                            : $registrant->programname }}
                                                               "
                                            />
                                            <span class="hint text-xs">Name as it will appear in the program</span>

                                        </x-inputs.group>

                                        {{-- AUDITION VOICING --}}
                                        <x-inputs.group x-data label="Audition part" for="instrumentations[0]"
                                                        borderless="true" paddingless="true">
                                            @for($i=0; $i < $eventversion['eventversionconfigs']->instrumentation_count; $i++)
                                                <select name="instrumentations[]">
                                                    @forelse($eventversion->eventensembles->first()->eventensembletype()->instrumentations AS $instrumentation)
                                                        <option value="{{ $instrumentation->id }}"
                                                                @if ($registrant->instrumentations->count() &&
                                                                    $registrant->instrumentations[$i]->id == $instrumentation->id)
                                                                SELECTED
                                                            @endif
                                                        >
                                                            {{ $instrumentation->descr }}
                                                        </option>
                                                    @empty
                                                        None found
                                                    @endforelse
                                                </select>
                                            @endfor

                                        </x-inputs.group>

                                        <footer class="mt-4 bg-gray-200 flex justify-end space-x-2 p-2">
                                            <div class="font-italic @if(isset($message)) bg-green-200 @endif px-2"
                                            >
                                                {{ isset($message) ? $message : ''}}
                                            </div>
                                            <x-buttons.button type="submit">
                                                Update {{ $registrant->student->person->first }} </x-buttons.button>

                                        </footer>

                                    </form>

                                    {{-- APPLICATION --}}
                                    <div class="bg-red-50 text-center mx-2 py-2 border border-red-200">

                                        @if(config('app.url') === 'http://localhost') {{-- working in dev --}}
                                            @if($eventversion['eventversionconfigs']->eapplication) {{-- is an eApplication eventversion --}}
                                                @if($registrant->hasApplication) {{-- eApplication is on file --}}
                                                    <a href="{{ route('registrant.application.create',['registrant' => $registrant]) }}"
                                                       class="text-blue-700">
                                                        Click here for the current eApplication
                                                    </a>
                                                @else {{-- no current record or not eApplication eventversion --}}
                                                    <a href="{{ route('registrant.application.create',['registrant' => $registrant]) }}"
                                                       class="text-blue-700">
                                                        Click here for a new eApplication
                                                    </a>
                                                @endif
                                            @else {{-- eventversion is NOT an eApplication eventversion --}}
                                                <a href="{{ route('registrant.application.create',['registrant' => $registrant]) }}"
                                                   class="text-blue-700">
                                                    Click here for the Application pdf
                                                    @if($registrant->applications->count())
                                                        <span title="Applications downloaded">
                                                            ({{ $registrant->applications->count() }})
                                                        </span>
                                                    @endif
                                                </a>
                                            @endif
                                        @else {{-- working in prod --}}
                                            @if($eventversion['eventversionconfigs']->eapplication) {{-- is an eApplication eventversion --}}
                                                @if($registrant->hasApplication) {{-- eApplication is on file --}}
                                                    <a href="https://thedirectorsroom.com/registrant/{{ $registrant->id }}/application/show" class="text-blue-700">
                                                        Click here for the current eApplication
                                                    </a>
                                                @else {{-- no current record or not eApplication eventversion --}}
                                                <a href="https://thedirectorsroom.com/registrant/{{ $registrant->id }}/application"
                                                   class="text-blue-700">
                                                    Click here for a new eApplication
                                                </a>
                                                @endif
                                            @else {{-- eventversion is NOT an eApplication eventversion --}}
                                                <a href="https://thedirectorsroom.com/registrant/{{ $registrant->id }}/application"
                                                   class="text-blue-700">
                                                    Click here for the Application pdf
                                                    @if($registrant->applications->count())
                                                        <span title="Applications downloaded">
                                                                ({{ $registrant->applications->count() }})
                                                            </span>
                                                    @endif
                                                </a>
                                            @endif
                                        @endif
                                            <!-- {{--
                                            @if($registrant->hasApplication) {{-- eApplication is on file
                                                <a href="{{ route('registrant.application.create',['registrant' => $registrant]) }}"
                                                    class="text-blue-700">
                                                    Click here for the current
                                                    {{ $eventversion['eventversionconfigs']->eapplication  ? 'eApplication' : 'Application pdf' }}
                                                    @if($registrant->applications->count())
                                                        <span title="Applications downloaded">
                                                        ({{ $registrant->applications->count() }})
                                                    </span>
                                                    @endif
                                                </a>
                                            @else {{-- no current record or not eApplication eventversion
                                                <a href="{{ route('registrant.application.create',['registrant' => $registrant]) }}"
                                                   class="text-blue-700">
                                                    Click here for a new
                                                    {{ $eventversion['eventversionconfigs']->eapplication  ? 'eApplication' : 'Application pdf' }}
                                                    @if($registrant->applications->count())
                                                        <span title="Applications downloaded">
                                                                ({{ $registrant->applications->count() }})
                                                            </span>
                                                    @endif
                                                </a>
                                            @endif
                                        }}-- -->
                                        @else

                                        @endif

                                        <!-- {{--
                                        <a
                                            @if($registrant->hasApplication)
                                            href="{{ route('registrant.application.show',['registrant' => $registrant]) }}"
                                            class="text-blue-700">
                                            @else
                                                href="{{ route('registrant.application.create',['registrant' => $registrant]) }}
                                                " class="text-blue-700">
                                            @endif
                                            Click here for the
                                            {{ $eventversion['eventversionconfigs']->eapplication  ? 'eApplication' : 'Application pdf' }}
                                            @if($registrant->applications->count())
                                                <span title="Applications downloaded">
                                                        ({{ $registrant->applications->count() }})
                                                    </span>
                                            @endif
                                        </a>
                                        --}} -->

                                        <div>
                                            @if(! $registrant->eventversion->eventversionconfigs->eapplication)
                                                @if($registrant->hasApplication)
                                                    @if($registrant->hasSignatures)
                                                        <div class="my-2 px-2 bg-green-100 ">
                                                            Signatures confirmed at: {{ $registrant->signatureconfirmation }}
                                                        </div>
                                                    @endif
                                                    @if(config('app.url') === 'http://localhost')
                                                        <a href="{{ route('registrant.signatures', ['registrant' => $registrant]) }}"
                                                            class="rounded"
                                                        >
                                                    @else
                                                        <a href="https://thedirectorsroom.com/registrant/{{ $registrant->id }}/signatures"
                                                           class="rounded"
                                                        >
                                                    @endif
                                                        <button class="bg-gray-500 mt-2 py-1 px-2 rounded">
                                                            @if($registrant->hasSignatures)
                                                                Remove my signature
                                                            @else
                                                                I confirm that the application has all required signatures.
                                                            @endif
                                                        </button>
                                                    </a>
                                                @endif
                                            @else
                                                Application has {{ $countsignatures }} signature(s)
                                            @endif

                                        </div>

                                    </div>

                                    {{-- FILE UPLOAD ADVISORY --}}
                                    <div id="advisory"
                                         class="text-center bg-gray-50 border border-gray-800 text-info mx-2 p-2 mb-2">
                                        <b>Teachers</b> may upload audition recordings
                                        from:<br/> {{ $eventversion->dates('videos_membership_open') }}
                                    <!-- {{-- and ends on {{ Carbon\Carbon::parse($eventversion->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'videos_membership_close')->first()->id)->first()->dt )->format('F jS') }}. --}} -->
                                        through {{ $eventversion->dates('videos_membership_close') }}.
                                        <br/>
                                        <b>Students</b> may upload audition recordings
                                        from:<br/>{{ $eventversion->dates('videos_student_open') }}
                                    <!-- {{-- and ends on {{ Carbon\Carbon::parse($eventversion->eventversiondates->where('datetype_id', \App\Datetype::where('descr', 'videos_student_close')->first()->id)->first()->dt)->format('F jS') }} --}} -->
                                        through {{ $eventversion->dates('videos_student_close') }}.
                                    </div>



                                    {{-- FILE UPLOADS --}}
                                    <div class=" mx-2 p-2">
                                        @if($eventversion->eventversionconfigs->virtualaudition)
                                            <h2 class="font-bold">File Uploads and Reviews</h2>

                                            @if((! $registrant->hasApplication) && (! $eventversion->eventversionconfigs->eapplication))

                                                <div class="advisory">
                                                    The student's application must be downloaded before
                                                    files can be uploaded.
                                                </div>

                                            @else
File content types: {{ $eventversion->filecontenttypes->count() }}
                                                @foreach($eventversion->filecontenttypes AS $filecontenttype)

                                                    <div class="shadow-lg rounded border-2 mb-4">
                                                        <h3 class="pl-2 pt-1">
                                                            {{ ucwords($filecontenttype->descr) }}
                                                            {{-- SOLO/QUARTET/etc have titles (ex. The Siver Swan --}}
                                                            {{-- SCALES might have NO title --}}
                                                            @if(strlen($filecontenttype->pivot->title))
                                                                : <span
                                                                    class="font-bold">{{ $filecontenttype->pivot->title }}</span>
                                                            @endif
                                                        </h3>

                                                        @if($registrant->hasFileUploaded($filecontenttype))
{{-- START VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT --}}
                                                            <div class="w-full">
                                                                <div class="flex justify-center">
                                                                    {!! $registrant->fileviewport($filecontenttype) !!}
                                                                </div>

                                                                <div class="stats col-lg-4 ml-1">
<!-- {{--
                                                                    <div class="items mb-3">
                                                                        <div class="data_row col-12">
                                                                            <div
                                                                                class="registrant">{{ $registrant->auditiondetail->programname }}</div>
                                                                            <div
                                                                                class="filenname">{{ $registrant->video($videotype)['title'] }}</div>
                                                                            <div
                                                                                class="duration">{{ number_format($registrant->video($videotype)['duration'],0) }}
                                                                                seconds
                                                                            </div>
                                                                            <div
                                                                                class="approved_at">{{ $registrant->video($videotype)['approved'] }}</div>
                                                                        <!-- {-- <div class="server_id">{{ $registrant->video($videotype)['id'] }}<div> --} -->
                                                                        </div>
                                                                    </div>
--}} -->
                                                                    <div class="flex mx-2 my-4 justify-around">
                                                                        @if($registrant->fileuploadapproved($filecontenttype))
                                                                            <div class="text-green-700 text-xs font-bold bg-green-100 p-2">
                                                                                Approved: {{ $registrant->fileuploadapprovaltimestamp($filecontenttype) }}
                                                                            </div>
                                                                        @else
                                                                            <a href="{{ route('fileupload.approve',['registrant' => $registrant, 'filecontenttype' => $filecontenttype]) }}">
                                                                                <button
                                                                                    type="button"
                                                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                                                >
                                                                                    Approve
                                                                                </button>
                                                                            </a>
                                                                        @endif
                                                                        @if(config('app.url') === 'http://localhost')
                                                                            <a href="{{ route('fileupload.reject',['registrant' => $registrant, 'filecontenttype' => $filecontenttype]) }}">
                                                                        @else
                                                                            <a href="https://thedirectorsroom.com/registrant/reject/{{ $registrant->id }}/{{ $filecontenttype->id }}">
                                                                        @endif
                                                                            <button
                                                                                type="button"
                                                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                                                >
                                                                                Reject
                                                                            </button>
                                                                        </a>
<!-- {{--
                                                                        <div class="approved col-7">
                                                                            <input type="checkbox"
                                                                                   class="form-check-input approved"
                                                                                   name="approved"
                                                                                   id="approved_{{$filecontenttype->id}}"
                                                                                   value="approved"
                                                                                   server_id="{{ $registrant->fileuploads->where('filecontenttype_id', $filecontenttype->id)->first()->server_id }}"
                                                                                {{ $registrant->fileuploads->where('filecontenttype_id',$filecontenttype->id)->first()->approved ? "CHECKED" : '' }}
                                                                            />
                                                                            <label
                                                                                class="form-check-label">Approved</label>
                                                                        </div>

                                                                        <div class="rejected col-11 ml-1 "
                                                                             server_id="{{ $registrant->video($videotype)['id'] }}">
                                                        <span class="text-danger"
                                                              style="font-size: .8rem; cursor:pointer;"
                                                              title="Reject this video"
                                                        >
                                                            Reject
                                                        </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                --}} -->
                                                            </div>
{{-- END VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT --}}
                                                        @else
                                                            <form action='https://api.sproutvideo.com/v1/videos'
                                                                  method='post'
                                                                  enctype='multipart/form-data'
                                                                  class="p-3 "
                                                            >

                                                                @csrf

                                                                <input type="hidden" name="token"
                                                                       value="{{ $fileserver->token($filecontenttype) }}"/>
                                                                <input type="hidden" name="download_sd" value="true"/>
                                                                <input type="hidden" name="download_hd" value="true"/>
                                                                <input type="hidden" name="title"
                                                                       value="{{ $filename.$filecontenttype->descr}}.mp3"/>
                                                                <input type="hidden" name="folder_id"
                                                                       value="{{ $folders->where('filecontenttype_id',$filecontenttype->id)->first()->folder_id }}">

                                                                <div class="form-group">
                                                                    <input type="file"
                                                                           id="filecontenttype_{{ $filecontenttype->id }}"
                                                                           name="audio" accept="audio/mp3"/>
                                                                    <div class="text-small text-muted">
                                                                        @if($eventversion->eventversionconfigs->audiofiles)
                                                                            <span
                                                                                class="hint">ONLY .mp3 files accepted</span>
                                                                        @elseif($eventversion->eventversionconfigs->videofiles)
                                                                            <span class="hint">ONLY .mp4/.mov files accepted</span>
                                                                        @else
                                                                            <span
                                                                                class="hint">No file uploads accepted{{$eventversion->eventversionconfigs->audiofiles}}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                {{-- SAVE BUTTON --}}
                                                                <div class="flex justify-end">
                                                                    <input
                                                                        class="bg-black text-white border rounded px-4 cursor-pointer"
                                                                        type="submit" name="submit"
                                                                        value="Upload {{ ucwords($filecontenttype->descr) }}"
                                                                    />
                                                                </div>

                                                            </form>
                                                        @endif
                                                    </div>

                                                @endforeach
                                            @endif
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                    </x-slot>

                    <x-slot name="actions">

                    </x-slot>

                </x-livewire-table-with-modal-forms>
            </div>
        </div>
    </div>

</x-app-layout>

