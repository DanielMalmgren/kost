@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välkommen till Åtvidabergs kostbeställningsportal!</div>

                <div class="card-body">

                    <a href="#" class="btn btn-primary disabled">Lägg matbeställning</a><br><br>
                    <a href="/menu" class="btn btn-primary">Redigera matsedel</a><br><br>
                    <a href="/course" class="btn btn-primary">Redigera maträtter</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
