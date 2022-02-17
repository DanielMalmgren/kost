@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">Portionsbeställning för LSS samt hemtjänst</div>

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

    <br>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">Matbeställning för avdelningar äldreomsorg</div>

                <div class="card-body">

                    <a href="/order_ao/create" class="btn btn-primary {{$user->isKost||$user->isHemtj?'':'disabled'}}">Lägg matbeställning</a>
                    <a href="/department_ao" class="btn btn-primary {{$user->isHemtj?'':'disabled'}}">Hantera avdelningar</a><br><br>
                    <a href="/menu_ao" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Redigera matsedel</a>
                    <a href="/print_ao" class="btn btn-primary {{$user->isKost?'':'disabled'}}">Skapa etiketter</a>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">Statistik antal beställningar</div>

                <div class="card-body">
                    @foreach($ordered_amount as $week => $amount)
                        Vecka {{$week}}: ???<br>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

</div>
@endsection
