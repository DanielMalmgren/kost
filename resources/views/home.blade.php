@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">Välkommen till Åtvidabergs kostbeställningsportal!</div>

                <div class="card-body">

                    <a href="/homecareorder/create" class="btn btn-primary {{$user->isKost||$user->isHemtj?'':'disabled'}}">Lägg matbeställning</a>
                    <a href="/customer" class="btn btn-primary {{$user->isHemtj?'':'disabled'}}">Hantera kunder</a>
                    <a href="/homecareorder" class="btn btn-primary {{$user->isKost||$user->isHemtj?'':'disabled'}}">Leveranslista</a><br><br>
                    <a href="/menu" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Redigera matsedel</a>
                    <a href="/course" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Redigera maträtter</a>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Statistik antal beställningar</div>

                <div class="card-body">
                    @foreach($ordered_amount as $week => $amount)
                        Vecka {{$week}}: {{$amount}}<br>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
