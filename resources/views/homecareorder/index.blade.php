@extends('layouts.app')

@section('content')

<script type="text/javascript">

    function updateOrder() {
        var week = $('#week').val();
        var group = $('#group').val();
        if(group != null) {
            $("#orders").load("/homecareorder/listajax?group=" + group + "&week=" + week);
        }
    }
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    Leveranslista
                </div>

                <div class="card-body">

                    <div class="form-row">
                        <div class="col">
                            <label for="week">Grupp</label>
                            <select class="custom-select d-block w-100" id="group" name="group" required="" onchange="updateOrder()">
                                <option selected disabled>Välj grupp</option>
                                @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{$group->Namn}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" style="max-width:150px">
                            <label for="week">Vecka</label>
                            <select class="custom-select d-block w-200" id="week" name="week" onchange="updateOrder()">
                                @foreach($weeks as $week)
                                    <option value="{{$week}}">{{$week}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div id="orders"></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
