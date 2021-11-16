<form method="post" name="question" action="{{action('HomeCareOrderController@store')}}" accept-charset="UTF-8">
    @csrf

    <input type="hidden" id="week" name="week" value="{{$week}}">
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="customer" value="{{$customer}}">

    @for ($i = 1; $i <= 8; $i++)
        <label for="alt[{{$i}}]">Alternativ {{$i}} ({{$chosen_courses[$i]}})</label>
        <select class="custom-select d-block w-100" name="amount[{{$i}}]" required="">
            @for ($j = 0; $j <= 9; $j++)
                <option {{$ordered_amount[$i]==$j?"selected":""}}>{{$j}}</option>
            @endfor
        </select>
        <br>
    @endfor

    <br>

    @if($almost_too_late)
        <div style="border-color:red;border-width:5px;border-style:solid;border-radius:0.3rem;padding-left:10px;font-size:1.5rem">
            Denna beställning inkommer efter brytdatum.<br>
            Det innebär att du själv måste kontakta köket och meddela dem om avvikelse!
        </div>
        <br>
    @endif

    <button {{$too_late?"disabled":""}} class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
