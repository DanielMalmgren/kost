@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function updateOrder() {
        var month = $('#month').val();
        $("#orders").load("/aodebit/listajax?month=" + month);
    }
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Debiteringslista
                </div>

                <div class="card-body">

                    <label for="month">Månad</label>
                    <select class="custom-select d-block w-200" id="month" name="month" onchange="updateOrder()">
                        @foreach($months as $month => $text)
                            <option {{$month===array_key_last($months)?'selected':''}} value="{{$month}}">{{$text}}</option>
                        @endforeach
                    </select>

                    <br>

                    <div id="orders"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    updateOrder();
</script>

@endsection
