@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    Ange vilka kantiner som behöver finnas i specialkostvariant!
                </div>

                <div class="card-body">

<form method="post" name="question" action="{{action('PrintAOController@print')}}" accept-charset="UTF-8">
    @csrf

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach($weekdays as $weekdaynumber => $weekday)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{$weekdaynumber==1?'active':''}}" id="{{$weekdaynumber}}-tab" data-toggle="tab" href="#tab{{$weekdaynumber}}" role="tab" aria-controls="{{$weekdaynumber}}">{{$weekday}}<br>{{$dates[$weekdaynumber]->format('j/n')}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach($weekdays as $weekdaynumber => $weekday)

            <div class="tab-pane fade {{$weekdaynumber==1?'show active':''}}" id="tab{{$weekdaynumber}}" role="tabpanel" aria-labelledby="{{$weekdaynumber}}-tab">
            
                <br>
            
                <div class="container">
                    <div class="row justify-content-center">
                        <table style="text-align:center" class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <td></td>
                                    <th colspan="4" scope="col">Lunch 1<br>Spaghetti och köttfärssås</th>
                                    <th colspan="3" scope="col">Lunch 2<br>Pytt i panna</th>
                                    <th colspan="4" scope="col">Middag<br>Biff a la Lindström</th>
                                    @if($weekdaynumber==4 || $weekdaynumber==6 || $weekdaynumber==7)
                                        <th colspan="2" scope="col">Dessert<br>Pannacotta</th>
                                    @endif
                                </tr>
                                <tr>
                                    <td></td>
                                    <th scope="col">Potatis</th>
                                    <th scope="col">Kött</th>
                                    <th scope="col">Sås</th>
                                    <th scope="col">Grönsaker</th>
                                    <th scope="col">Potatis</th>
                                    <th scope="col">Kött</th>
                                    <th scope="col">Grönsaker</th>
                                    <th scope="col">Potatis</th>
                                    <th scope="col">Kött</th>
                                    <th scope="col">Sås</th>
                                    <th scope="col">Grönsaker</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Glutenfritt</th>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Vegetariskt</th>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Minus fisk</th>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Enbart gelé</th>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                    <td><input type="checkbox"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>

        @endforeach
    </div>

    <br>

    <button disabled class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Skapa pdf</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
