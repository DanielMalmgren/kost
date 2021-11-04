@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function updateOrder() {
        var customer = $('#customer').val();
        var week = $('#week').val();
        var type = $('#type').val();
        $("#courses").load("/homecareorder/ajax?type=" + type + "&customer=" + customer + "&week=" + week);
    }
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Lägg matbeställningen nedan!</div>

                <div class="card-body">

                    <div class="form-row">
                        <div class="col">
                            <label for="week">Kund</label>
                            <select class="custom-select d-block w-100" id="customer" name="customer" required="" onchange="updateOrder()">
                                <option selected disabled>Välj kund</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->Personnr}}">{{$customer->Namn}}</option>
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
                        <div class="col">
                            <label for="menu">Meny</label>
                            <select class="custom-select d-block w-200" id="type" name="type" onchange="updateOrder()">
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
