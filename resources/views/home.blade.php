@extends('layouts.app')

@section('content')
<div class="container">

    {{--
    @if($user->isHemtj||$user->isFakt)
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="card">
                    <div class="card-header">Portionsbeställning för LSS samt hemtjänst</div>

                    <div class="card-body">

                        @if($user->isHemtj)
                            <a href="/homecareorder/create" class="btn btn-primary">Lägg matbeställning</a>
                            <a href="/customer" class="btn btn-primary">Hantera kunder</a>
                            <a href="/homecareorder" class="btn btn-primary">Leveranslista</a>
                        @endif
                        @if($user->isFakt)
                            <a href="/homecaredebit" class="btn btn-primary">Debiteringslista</a><br><br>
                        @endif
                        @if($user->isKost)
                            <a href="/menu" class="btn btn-primary">Redigera matsedel</a>
                            <a href="/course" class="btn btn-primary">Redigera maträtter</a>
                            <a href="/print_hc" class="btn btn-primary">Skapa etiketter</a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-3">

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
    @endif
    --}}

    @if($user->isAO||$user->isFakt)
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="card">
                    <div class="card-header">Matbeställning för avdelningar äldreomsorg</div>

                    <div class="card-body">

                        @if($user->isAO)
                            <a href="/order_ao/create" class="btn btn-primary">Lägg matbeställning</a>
                            <a href="/menu_ao" class="btn btn-primary">Matsedel</a>
                        @endif
                        @if($user->isFakt)
                            <a href="/aodebit" class="btn btn-primary">Debiteringslista</a>
                        @endif
                        @if($user->isKost)
                            <br><br>
                            <a href="/department_ao" class="btn btn-primary">Hantera avdelningar</a>
                            <a href="/print_ao" class="btn btn-primary">Skapa etiketter</a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">Statistik antal beställningar</div>

                    <div class="card-body">
                        @foreach($ordered_amount_ao as $week => $amount)
                            Vecka {{$week}}: {{$amount}}<br>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    @endif

</div>
@endsection
