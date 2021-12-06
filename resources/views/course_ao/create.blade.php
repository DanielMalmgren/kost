@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('CourseAOController@store')}}" accept-charset="UTF-8">
                        @csrf

                        <label for="name">Namn</label>
                        <input name="name" class="form-control">

                        <br>

                        <label for="komp1">Ris/potatis/makaroner</label>
                        <select class="custom-select d-block w-100" name="komp1" required="">
                            <option>Ingenting</option>
                            <option>Ris</option>
                            <option>Potatis</option>
                            <option>Makaroner</option>
                        </select>

                        <br>

                        <label for="komp2">Kött/fisk</label>
                        <select class="custom-select d-block w-100" name="komp2" required="">
                            <option>Ingenting</option>
                            <option>Kött</option>
                            <option>Fisk</option>
                            <option>Soppa</option>
                        </select>

                        <br>

                        <label for="komp3">Sås</label>
                        <select class="custom-select d-block w-100" name="komp3" required="">
                            <option>Ingenting</option>
                            <option>Varm sås</option>
                            <option>Kall sås</option>
                        </select>

                        <br>

                        <label for="komp4">Grönsaker</label>
                        <select class="custom-select d-block w-100" name="komp4" required="">
                            <option>Ingenting</option>
                            <option>Frukt</option>
                            <option>Grönsaker</option>
                        </select>

                        <br>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
