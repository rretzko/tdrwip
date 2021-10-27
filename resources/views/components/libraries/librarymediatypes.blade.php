@props([
    'librarymediatypeid',
    'librarymediatypes'
])
<div class="flex flex-row justify-around bg-indigo-100">


    @foreach($librarymediatypes AS $librarymediatype)
        <div class=" border-r-2 border-black w-full text-center hover:bg-indigo-200">
            <a href="../{{ strtolower(str_replace(' ','',$librarymediatype->descr)) }}/new"
               class="text-indigo-400 hover:bg-indigo-200
                    @if($librarymediatype->id == $librarymediatypeid) text-indigo-800 font-bold @endif"
            >
                {{ ucwords($librarymediatype->descr) }}
            </a>
        </div>
    @endforeach
</div>
<script>
    function updateForm()
    {
        alert('updateForm');
    }
</script>
