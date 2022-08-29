@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">Välj vilken typ av etiketter som ska skrivas ut</div>

                <div class="card-body">

                    <a href="/print_hc/print?type=normal" class="btn btn-primary">Normalkost</a>
                    <a href="/print_hc/print?type=veg" class="btn btn-primary">Vegetarisk</a>
                    <a href="/print_hc/print?type=spec" class="btn btn-primary">Specialkost</a>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
