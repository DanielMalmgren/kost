<form method="post" name="question" action="{{action('MenuController@update')}}" accept-charset="UTF-8">
    @method('put')
    @csrf

    <input type="hidden" name="week" value="{{$week}}">
    <input type="hidden" name="type" value="{{$type}}">

    @for ($i = 1; $i <= 8; $i++)
        <label for="alt[{{$i}}]">Alternativ {{$i}}</label>
        <select class="custom-select d-block w-100" name="alt[{{$i}}]" required="">
            @if ($chosen_courses[$i]==-1)
                <option selected disabled>Vänligen välj maträtt</option>
            @endif
            @foreach($courses as $course)
                <option {{$chosen_courses[$i]==$course->id?"selected":""}} value="{{$course->id}}">{{$course->Namn}}</option>
            @endforeach
        </select>
        <br>
    @endfor

    <br>

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
