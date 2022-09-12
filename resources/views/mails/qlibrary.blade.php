<div>
    <h3>The following library categories are important to {{ auth()->user()->person->fullName.' ('.auth()->id().')' }}</h3>
    <ul>
        @isset($title)<li>Title</li>@endif
        @isset($subtitle)<li>Subtitle</li>@endif
        @isset($composer)<li>Composer</li>@endif
        @isset($arranger)<li>Arranger</li>@endif
        @isset($publisher)<li>Publisher</li>@endif
        @isset($arrangement)<li>Arrangement</li>@endif
        @isset($accompaniment)<li>Accompaniment</li>@endif
        @isset($language)<li>Language</li>@endif
        @isset($tempo)<li>Tempo</li>@endif
        @isset($year)<li>Year Performed</li>@endif
        @isset($ensemble)<li>Performed BY</li>@endif
        @isset($concert)<li>Performed At</li>@endif
        @isset($comments)<li>Comments</li>@endif
        @isset($must_haves)<li>Must Haves: {{ $must_haves }}</li>@endif
        @isset($nice_haves)<li>Nice to haves: {{ $nice_haves }}</li>@endif
    </ul>
</div>
