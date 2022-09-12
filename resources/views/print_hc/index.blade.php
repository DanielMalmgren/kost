@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">Välj vilken typ av etiketter som ska skrivas ut</div>

                <div class="card-body">

                    <a href="/print_hc/print?type=Normal" class="btn btn-primary">Normalkost</a>
                    <a href="/print_hc/print?type=Vegetarisk" class="btn btn-primary">Vegetarisk</a>
                    <a href="/print_hc/print?type=Specialkost" class="btn btn-primary">Specialkost</a>
                    <a href="/print_hc/print?type=Test" class="btn btn-primary">Testlådor</a>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
