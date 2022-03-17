@extends('layouts.pdfapp')

@section('title', 'Etiketter äldreomsorg')

@section('content')

    <style>
        @page {
            margin-top: 16mm;
            margin-bottom: 5mm;
            margin-right: 0mm;
            margin-left: 0mm;
        }

        .label {
            float: left;
            width: 50%;
            height: 38mm;
            border-style: dashed;
            position:relative;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .bottom_right {
            position:absolute;
            bottom:0;
            right:0;
            padding:3mm;
            color: red;
        }

        .bottom_left {
            position:absolute;
            bottom:0;
            left:0;
            padding:3mm;
            font-size: 75%;
        }

        .top_right {
            position:absolute;
            top:0;
            right:0;
            padding:3mm;
            font-size: 125%;
        }

        .top_left {
            position:absolute;
            top:0;
            left:0;
            padding:3mm;
            font-size: 125%;
        }

        .center {
            position: absolute; 
            top: 13mm; 
            left: 30mm; 
            font-size: 175%;
        }

        .ph {
            height: 10px;
        }
    </style>

    @foreach($labels->split(ceil($labels->count()/2)) as $row)
        <div class="row">
            @foreach($row as $label)
                <div class="label">
                    <div class="ph"></div>
                    <div class="top_left">
                        {{$label['date']}}
                    </div>
                    <div class="center">
                        {{$label['amount']}} {{$label['comp']}}
                    </div>
                    <div class="top_right">
                        {{$label['department']}}
                    </div>
                    <div class="bottom_left">
                        {{$label['course']}}
                    </div>
                    <div class="bottom_right">
                        {{$label['diet']}}
                    </div>
                </div>
            @endforeach
        </div> 
    @endforeach

@endsection
