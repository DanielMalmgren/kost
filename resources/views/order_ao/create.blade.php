@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">

    function updateOrder() {
        var department = $('#department').val();
        var week = $('#week').val();
        if(department != null) {
            $("#courses").load("/order_ao/ajax?department=" + department + "&week=" + week);
        }
    }
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Lägg matbeställningen nedan!
                </div>

                <div class="card-body">

                    <div class="form-row">
                        <div class="col">
                            <label for="week">Avdelning</label>
                            <select class="custom-select d-block w-100" id="department" name="department" required="" onchange="updateOrder()">
                                <option selected disabled>Välj avdelning</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->Namn}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" style="max-width:150px">
                            <label for="week">Vecka</label>
                            <select class="custom-select d-block w-200" id="week" name="week" onchange="updateOrder()">
                                @foreach($weeks as $week)
                                    <option {{$week==$prechosen_week?"selected":""}} value="{{$week}}">{{$week}}</option>
                                @endforeach
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
