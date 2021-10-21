@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function updateCourses() {
        var week = $('#week').val();
        var type = $('#type').val();
        $("#courses").load("/menu/ajax/" + week + "?type=" + type);
    }

    $(function() {
        updateCourses();
    });
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välj vilka maträtter som ska vara på menyn nedan!</div>

                <div class="card-body">

                    <div class="form-row">
                        <div class="col">
                            <label for="week">Vecka</label>
                            <select class="custom-select d-block w-200" id="week" name="week" onchange="updateCourses()">
                                @foreach($weeks as $week)
                                    <option {{$week==$current_week?"selected":""}} value="{{$week}}">{{$week}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="menu">Meny</label>
                            <select class="custom-select d-block w-200" id="type" name="type" onchange="updateCourses()">
                                <option selected value="Normal">Normal</option>
                                <option value="Vegetarisk">Vegetarisk</option>
                            </select>
                        </div>
                    </div>

                    <br>

                    <div id="courses"></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
