<style>
    label{text-align: center; border: 1px solid black;background-color: lightgray;}
    .box{min-width: 6rem; max-width: 6rem; width: 6rem;}
</style>
<div class="ml-4">

    {{-- TOTAL SCORE --}}
    <div class="flex flex-row font-bold text-lg">
        <div >Your Total Score: </div>
        <div id="judgeTotal" class="ml-2 " ></div>
    </div>

    @foreach($room->filecontenttypes AS $filecontenttype)
        <div>
            <h3 class="uppercase text-lg">{{ $filecontenttype->descr }}</h3>
            <div class="flex flex-row">
            @foreach($scoringcomponents->where('filecontenttype_id', $filecontenttype->id)->sortBy('order_by') AS $scoringcomponent)

                <div class="flex flex-col">
                    <label class="box" for="" title="{{ $scoringcomponent->descr }}">{{ $scoringcomponent->abbr }}</label>
                    <select class="box" id="box{{ $scoringcomponent->order_by }}" name="scoringcomponents[{{$scoringcomponent->id}}]" onchange="recalcScore()">
                        @for($i=$scoringcomponent->bestscore; $i<=$scoringcomponent->worstscore; $i=$i+$scoringcomponent->interval)
                            <option value="{{ $i }}"
                                @if($auditioner->scoringcomponentScore($useradjudicator, $scoringcomponent) === $i) SELECTED @endif
                            >
                                {{$i}}
                            </option>
                        @endfor
                    </select>

                </div>
            @endforeach

            </div>

        </div>
    @endforeach

    <script>
        window.onload = recalcScore();
        function recalcScore(){
            var $e1 = (document.getElementById('box1')) ? document.getElementById('box1').value : 0;
            var $e2 = (document.getElementById('box2')) ? document.getElementById('box2').value : 0;
            var $e3 = (document.getElementById('box3')) ? document.getElementById('box3').value : 0;
            var $e4 = (document.getElementById('box4')) ? document.getElementById('box4').value : 0;
            var $e5 = (document.getElementById('box5')) ? document.getElementById('box5').value : 0;
            var $e6 = (document.getElementById('box6')) ? document.getElementById('box6').value : 0;
            var $e7 = (document.getElementById('box7')) ? document.getElementById('box7').value : 0;
            var $e8 = (document.getElementById('box8')) ? document.getElementById('box8').value : 0;
            var $e9 = (document.getElementById('box9')) ? document.getElementById('box9').value : 0;
            var $e10 = (document.getElementById('box10')) ? document.getElementById('box10').value : 0;

            var $tot = (parseInt($e1)+ parseInt($e2) + parseInt($e3) + parseInt($e4) + parseInt($e5) + parseInt($e6) + parseInt($e7) + parseInt($e8) + parseInt($e9) + parseInt($e10));

            document.getElementById('judgeTotal').innerHTML = $tot;
        }
    </script>
</div>

