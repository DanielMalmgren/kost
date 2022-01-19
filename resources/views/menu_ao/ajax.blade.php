<form method="post" name="question" action="{{action('MenuAOController@update')}}" accept-charset="UTF-8">
    @method('put')
    @csrf

    @for ($weekday = 1; $weekday <= 7 ; $weekday++)

        <input type="hidden" name="date[{{$weekday}}]" value="{{$dates[$weekday]->format('Y-m-d')}}">

        <div class="card">
            <div class="card-header">{{$weekdays[$weekday]}} ({{$dates[$weekday]->format('Y-m-d')}})</div>

            <div class="card-body">

                <div class="form-row">
                    <div class="col-2">
                        <label>Lunch 1</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="lunch1[{{$weekday}}]" required="">
                            @if(!isset($chosen_courses[$weekday]) || $chosen_courses[$weekday]->Lunch1==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$weekday])&&$chosen_courses[$weekday]->Lunch1==$course->id?'selected':''}} value="{{$course->id}}">{{$course->Namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-2">
                        <label>Lunch 2</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="lunch2[{{$weekday}}]" required="">
                            @if(!isset($chosen_courses[$weekday]) || $chosen_courses[$weekday]->Lunch2==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$weekday])&&$chosen_courses[$weekday]->Lunch2==$course->id?'selected':''}} value="{{$course->id}}">{{$course->Namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-2">
                        <label>Middag</label>
                    </div>
                    <div class="col-7">
                        <select class="custom-select d-block w-100" name="middag[{{$weekday}}]" required="">
                            @if(!isset($chosen_courses[$weekday]) || $chosen_courses[$weekday]->Middag==-1)
                                <option selected disabled>Välj maträtt</option>
                            @endif
                            @foreach($courses as $course)
                                <option {{isset($chosen_courses[$weekday])&&$chosen_courses[$weekday]->Middag==$course->id?'selected':''}} value="{{$course->id}}">{{$course->Namn}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($weekday==4 || $weekday==6 || $weekday==7)
                    <div class="form-row">
                        <div class="col-2">
                            <label>Dessert</label>
                        </div>
                        <div class="col-7">
                            <select class="custom-select d-block w-100" name="dessert[{{$weekday}}]" required="">
                                @if(!isset($chosen_courses[$weekday]) || $chosen_courses[$weekday]->Dessert==-1)
                                    <option selected disabled>Välj dessert</option>
                                @endif
                                @foreach($courses as $course)
                                    <option {{isset($chosen_courses[$weekday])&&$chosen_courses[$weekday]->Dessert==$course->id?'selected':''}} value="{{$course->id}}">{{$course->Namn}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <br>

    @endfor

    <br>

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
