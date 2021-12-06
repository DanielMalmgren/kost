<form method="post" name="question" action="{{action('MenuAOController@update')}}" accept-charset="UTF-8">
    @method('put')
    @csrf

    @for ($i = 1; $i <= 7 ; $i++)

        <input type="hidden" name="date[{{$i}}]" value="{{$dates[$i]->format('Y-m-d')}}">

        <div class="card">
            <div class="card-header">{{$weekdays[$i]}} ({{$dates[$i]->format('Y-m-d')}})</div>

            <div class="card-body">

                <div class="form-row">
                    <div class="col-2">
                        <label>Lunch 1</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="lunch1[{{$i}}]" required="">
                            @if(!isset($chosen_courses[$i]) || $chosen_courses[$i]->Lunch1==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$i])&&$chosen_courses[$i]->Lunch1==$course->id?'selected':''}} value="{{$course->id}}">{{$course->namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-2">
                        <label>Lunch 2</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="lunch2[{{$i}}]" required="">
                            @if(!isset($chosen_courses[$i]) || $chosen_courses[$i]->Lunch2==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$i])&&$chosen_courses[$i]->Lunch2==$course->id?'selected':''}} value="{{$course->id}}">{{$course->namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-2">
                        <label>Middag</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="middag[{{$i}}]" required="">
                            @if(!isset($chosen_courses[$i]) || $chosen_courses[$i]->Middag==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$i])&&$chosen_courses[$i]->Middag==$course->id?'selected':''}} value="{{$course->id}}">{{$course->namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <br>

    @endfor

    <br>

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
