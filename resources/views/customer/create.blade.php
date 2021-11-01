@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('CustomerController@store')}}" accept-charset="UTF-8">
                        @csrf

                        <div class="mb-5">
                            <label for="name">Namn</label>
                            <input required name="namn" class="form-control" value="{{old('namn')}}">
                        </div>

                        <div class="mb-5">
                            <label for="name">Personnummer</label>
                            <input required name="personnr" class="form-control" value="{{old('personnr')}}">
                        </div>

                        <div class="mb-5">
                            <label for="group">Grupp</label>
                            <select required class="custom-select d-block w-100" name="group" required="">
                                <option selected disabled>Välj grupp</option>
                                @foreach($groups as $group)
                                    <option {{old('group')==$group->id?"selected":""}} value="{{$group->id}}">{{$group->Namn}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="name">Specialkost</label>
                            <select required class="custom-select d-block w-100" id="specialkost" name="specialkost" required="">
                                <option>Normal</option>
                                <option>Vegetarisk</option>
                                <option>Annat</option>
                            </select>
                            <input style=display:none id="specialkost_annan" name="specialkost_annan" class="form-control">
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-9">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-lg btn-danger btn-block" onclick="delete_course()">Radera</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#specialkost').on('change', function (e) {
        var specialkost = $('#specialkost').val();
        if(specialkost != 'Normal' && specialkost != 'Vegetarisk') {
            $('#specialkost_annan').show();
        } else {
            $('#specialkost_annan').hide();
        }
    });

</script>

@endsection
