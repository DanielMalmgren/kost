@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välkommen till Åtvidabergs kostbeställningsportal!</div>

                <div class="card-body">

                    <a href="/homecareorder/create" class="btn btn-primary {{$user->isKost||$user->isHemtj?'':'disabled'}}">Lägg matbeställning</a><br><br>
                    <a href="/customer" class="btn btn-primary {{$user->isHemtj?'':'disabled'}}">Hantera kunder</a><br><br>
                    <a href="/menu" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Redigera matsedel</a><br><br>
                    <a href="/course" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Redigera maträtter</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
