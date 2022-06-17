@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    Ange vilka kantiner som behöver finnas i specialkostvariant!
                </div>

                <div class="card-body">

                    <div class="form-row">
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

<script type="text/javascript">

    function updateOrder() {
        var week = $('#week').val();
        $("#courses").load("/print_ao/choose?week=" + week);
    }

    updateOrder();
</script>

@endsection
