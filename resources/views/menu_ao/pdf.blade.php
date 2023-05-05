@extends('layouts.pdfapp')

@section('title', 'Matsedel äldreomsorg')

@section('content')

    <style>
        @page { margin: 0px 0px; }

        body {
            background-image:url({{url('/')}}/images/menu_background.png);
            background-repeat:no-repeat;
            width:100%;
            height:100vh;
            background-size: cover;
        }

        .weeklist {
            margin-top: 100px;
            margin-left: 100px;
        }

        .lunch2 {
            font-size: 125%;
            font-weight: bold;
        }

    </style>

    <div class="weeklist">

        <h1>Matsedel vecka {{$week}}</h1><br>

        @for ($weekday = 1; $weekday <= 7 ; $weekday++)

            <b>{{$weekdays[$weekday]}} ({{$dates[$weekday]->format('Y-m-d')}})</b>
            <br>

            <table>
                <tr>
                    <td width="90px">Lunch 1</td>
                    @if(isset($chosen_courses[$weekday]))
                        <td>{{$chosen_courses[$weekday]->Lunch1_object->Namn}}</td>
                    @else
                        <td>Ingen meny lagd för denna dag</td>
                    @endif
                </tr>
                <tr>
                    <td width="90px">Kvällsmat</td>
                    @if(isset($chosen_courses[$weekday]))
                        <td>{{$chosen_courses[$weekday]->Middag_object->Namn}}</td>
                    @else
                        <td>Ingen meny lagd för denna dag</td>
                    @endif
                </tr>

                @if($weekday==4 || $weekday==6 || $weekday==7)
                    <tr>
                        <td width="90px">Dessert</td>
                        @if(isset($chosen_courses[$weekday]))
                            <td>{{$chosen_courses[$weekday]->Dessert_object->Namn}}</td>
                        @else
                            <td>Ingen meny lagd för denna dag</td>
                        @endif
                    </tr>
                @endif
            </table>

            <br>

        @endfor

        <br>

        <div class="lunch2">

            <table>
                <tr>
                    <td width="90px">Lunch 2</td>
                    @if(isset($chosen_courses[1]))
                        <td>{{$chosen_courses[1]->Lunch2_object->Namn}}</td>
                    @else
                        <td>Ingen meny lagd för denna dag</td>
                    @endif
                </tr>
            </table>
        </div>

    </div>

@endsection
