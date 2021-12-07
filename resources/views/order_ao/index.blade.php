@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Lunch 1 - Fläskpannkaka</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="col-8">
                            <label>Portioner totalt</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="10">
                        </div>
                    </div>

                    <label>Varav specialkost</label>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus strömming</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus fläsk</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Lunch 2 - Oxjärpar med klyftpotatis</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="col-8">
                            <label>Portioner totalt</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="10">
                        </div>
                    </div>

                    <label>Varav specialkost</label>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus strömming</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus fläsk</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Middag - Ugnsfalukorv och potatismos</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="col-8">
                            <label>Portioner totalt</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="10">
                        </div>
                    </div>

                    <label>Varav specialkost</label>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus strömming</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus fläsk</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Dessert - Aprikoskräm</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="col-8">
                            <label>Portioner totalt</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="10">
                        </div>
                    </div>

                    <label>Varav specialkost</label>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus strömming</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-8">
                            <label>Minus fläsk</label>
                        </div>
                        <div class="col-3">
                            <input type="number" min="0" name="whatever" class="form-control" value="1">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
