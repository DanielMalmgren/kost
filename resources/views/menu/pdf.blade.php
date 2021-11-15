@extends('layouts.pdfapp')

@section('title', 'Matsedel vecka '.$week)

@section('content')

    <style>
        @page { margin: 0px 0px; }
        footer { position: fixed; left: 20px; right: 0px; height: 50px; }
        @font-face {
            font-family: "Bodoni italic";
            src: url({{env('APP_URL')}}/fonts/BodoniFLF-Italic.ttf) format("truetype");
        }
        body {
            background-image:url({{env('APP_URL').'/images/Atv_top.png'}});
            background-repeat:no-repeat;
            width:100%;
            height:100vh;
            color: #000000;
            font-family: "Bodoni italic";
        }
        .bigcontent {
            margin-top: 180px;
            line-height: 120%;
            font-size: 35px;
            text-align: center;
        }
        .smallcontent {
            margin-top: 30px;
            margin-left: 160px;
            line-height: 130%;
            font-size: 25px;
        }
        table {
            margin-left: 50px;
        }
    </style>

     <footer>
        <p style="position:absolute;bottom:0;">Har du frågor kring beställningen hör av dig till 0120-83264 eller 0120-83295</p>
    </footer>

    <div class="bigcontent">
        Matsedel vecka {{$week}}<br><br>
    </div>

    <table>
        <tr>
            <td>Namn</td>
            <td style="border-width:2px;border-style:solid;border-radius:0.3rem;width:500px;height:30px"> </td>
        </tr>
        <tr>
            <td>Specialkost</td>
            <td style="border-width:2px;border-style:solid;border-radius:0.3rem;width:500px;height:30px"> </td>
        </tr>
    </table>

    <br>

    <table>
        @for($i=1; $i <= 8; $i++)
            <tr>
                <td>
                    Alternativ {{$i}}:
                    @isset($standard_courses[$i])
                        {{$standard_courses[$i]->Namn}}
                    @endisset
                </td>
                <td style="border-width:2px;border-style:solid;border-radius:0.3rem;width:100px;height:30px"> </td>
            </tr>
        @endfor
        <tr><td style="height:30px;"> </td></tr>
        @for($i=1; $i <= 8; $i++)
            <tr>
                <td>
                    Alternativ {{$i}}:
                    @isset($vegetarian_courses[$i])
                        {{$vegetarian_courses[$i]->Namn}}
                    @endisset
                </td>
                <td style="border-width:2px;border-style:solid;border-radius:0.3rem;width:100px;height:30px"> </td>
            </tr>
        @endfor
    </table>

@endsection
