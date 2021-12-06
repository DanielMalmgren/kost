@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('DepartmentAOController@store')}}" accept-charset="UTF-8">
                        @csrf

                        <div class="mb-5">
                            <label for="name">Namn</label>
                            <input required name="namn" class="form-control" value="{{old('namn')}}">
                        </div>

                        <div class="mb-5">
                            <label for="name">Antal boende</label>
                            <input type="number" min="0" name="boende" class="form-control" value="{{old('boende')}}">
                        </div>

                        <label>Specialkostbehov</label>
                        @foreach($special_diets as $special_diet)
                            <div class="form-row">
                                <div class="col-4">
                                    <label>{{$special_diet->Namn}}</label>
                                </div>
                                <div class="col-2">
                                    <input type="number" min="0" name="special_diets[{{$special_diet->id}}]" class="form-control" value="0">
                                </div>
                            </div>
                        @endforeach

                        <br>

                        <div class="form-row">
                            <div class="col-9">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
