@extends('layouts.pdfapp')

@section('title', 'Etiketter hemtjänst')

@section('content')

    <style>
        @page {
            margin-top: 6mm;
            margin-bottom: 13mm;
            margin-right: 0mm;
            margin-left: 0mm;
        }

        .label {
            float: left;
            width: 50%;
            height: 55mm;
            border-top-style: dashed;
            border-width: thin;
            position:relative;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .bottom_left {
            position:absolute;
            bottom:0;
            left:1mm;
            padding:3mm;
            font-size: 75%;
        }

        .top_left {
            position:absolute;
            top:0;
            left:1mm;
            padding:3mm;
            font-size: 75%;
        }

        .top_right {
            position:absolute;
            top:0;
            right:4mm;
            padding:3mm;
            font-size: 105%;
            width: 60mm;
        }

        .spec {
            font-size: 165%;
            color: red;
        }

        .ph {
            height: 1mm;
        }
    </style>

    @foreach($labels->split(ceil($labels->count()/2)) as $row)
        <div class="row">
            @foreach($row as $label)
                <div class="label">
                    <div class="ph"></div>
                    <div class="top_right">
                        <b>{{$label['Namn']}}</b>
                    </div>
                    <div class="top_left">
                        <img src="{{url('/')}}/images/label_logo.png" width="100"><br><br>
                        @if($label['Specialkost']=='Vegetarisk' || $label['Specialkost']=='Normal')
                            Ingredienser: {{$label['Ingredienser']}}
                        @else
                            <span class="spec">
                                {{$label['Kund_namn']}}<br>
                                {{$label['Specialkost']}}
                            </span>
                        @endif
                    </div>
                    <div class="bottom_left">
                        Alternativ {{$label['Specialkost']=='Vegetarisk'?'vegetarisk':''}} {{$label['Alternativ']}}<br>
                        Förvaras i kyl max 5 grader.<br>
                        Stick hål i plasten och värm i micro ca 3 minuter på full effekt.<br>
                        För information om innehåll kontakta Alléköket, 0120-833 29<br>
                        Bäst före: <b>{{$expiredate}}</b>
                    </div>
                </div>
            @endforeach
        </div> 
    @endforeach

@endsection
