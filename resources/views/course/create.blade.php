@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('CourseController@store')}}" accept-charset="UTF-8">
                        @csrf

                        <div class="form-row">
                            <div class="col-9">
                                <label for="name">Namn</label>
                                <input name="name" class="form-control">
                            </div>
                            <div class="col">
                                <br>
                                <input type="hidden" name="vego" value="0">
                                <label><input type="checkbox" name="vego" value="1">Vegetarisk</label>
                            </div>
                        </div>

                        <br>

                        <div class="mb-5">
                            <label for="ingredients">Ingredienser</label>
                            <textarea rows=5 name="ingredients" class="form-control"></textarea>
                        </div>

                        <label for="komp1">Ris/potatis/makaroner</label>
                        <select class="custom-select d-block w-100" name="komp1" required="">
                            <option>Ingenting</option>
                            <option>Ris</option>
                            <option>Potatis</option>
                            <option>Makaroner</option>
                            <option>Ägg</option>
                        </select>

                        <br>

                        <label for="komp2">Kött/fisk</label>
                        <select class="custom-select d-block w-100" name="komp2" required="">
                            <option>Ingenting</option>
                            <option>Kött</option>
                            <option>Fisk</option>
                            <option>Soppa</option>
                            <option>Gratäng</option>
                            <option>Vegetariskö</option>
                        </select>

                        <br>

                        <label for="komp3">Sås</label>
                        <select class="custom-select d-block w-100" name="komp3" required="">
                            <option>Ingenting</option>
                            <option>Varm sås</option>
                            <option>Kall sås</option>
                            <option>Stuvning</option>
                        </select>

                        <br>

                        <label for="komp4">Grönsaker</label>
                        <select class="custom-select d-block w-100" name="komp4" required="">
                            <option>Ingenting</option>
                            <option>Frukt</option>
                            <option>Grönsaker</option>
                            <option>Bröd</option>
                            <option>Dessert</option>
                        </select>

                        <br><br>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
