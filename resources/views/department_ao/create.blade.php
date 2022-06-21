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

                        <div class="form-row">
                            <div class="col-2">
                                <label for="Lunch">Lunch</label>
                                <input name="Lunch" value="0" type="hidden">
                                <input checked name="Lunch" value="1" type="checkbox">
                            </div>

                            <div class="col-2">
                                <label for="Middag">Middag</label>
                                <input name="Middag" value="0" type="hidden">
                                <input checked name="Middag" value="1" type="checkbox">
                            </div>
                        </div>

                        <br>

                        <label>Specialkostbehov</label>
                        <div class="form-row">
                            <div class="col-5">
                                <input name="new_special_diet[1][name]" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" min="0" name="new_special_diet[1][amount]" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                <input name="new_special_diet[2][name]" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" min="0" name="new_special_diet[2][amount]" class="form-control" value="0">
                            </div>
                        </div>

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
