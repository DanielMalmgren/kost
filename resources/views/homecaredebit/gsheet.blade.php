@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Debiteringslista kalkylark
                </div>

                <div class="card-body">

                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/{{$id}}">https://docs.google.com/spreadsheets/d/{{$id}}</a>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
