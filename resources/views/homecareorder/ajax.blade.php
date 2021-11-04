<form method="post" name="question" action="{{action('HomeCareOrderController@store')}}" accept-charset="UTF-8">
    @csrf

    <input type="hidden" name="week" value="{{$week}}">
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

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
