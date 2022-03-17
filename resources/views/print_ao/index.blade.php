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
                                    <th colspan="{{$chosen_courses['Lunch1'][$weekdaynumber]->components()}}" scope="col">Lunch 1<br>{{$chosen_courses['Lunch1'][$weekdaynumber]->Namn}}</th>
                                    <th colspan="{{$chosen_courses['Lunch2'][$weekdaynumber]->components()}}" scope="col">Lunch 2<br>{{$chosen_courses['Lunch2'][$weekdaynumber]->Namn}}</th>
                                    <th colspan="{{$chosen_courses['Middag'][$weekdaynumber]->components()}}" scope="col">Middag<br>{{$chosen_courses['Middag'][$weekdaynumber]->Namn}}</th>
                                    @if($weekdaynumber==4 || $weekdaynumber==6 || $weekdaynumber==7)
                                        <th colspan="{{$chosen_courses['Dessert'][$weekdaynumber]->components()}}" scope="col">Dessert<br>{{$chosen_courses['Dessert'][$weekdaynumber]->Namn}}</th>
                                    @endif
                                </tr>
                                <tr>
                                    <td></td>
                                    @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent1 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch1'][$weekdaynumber]->komponent1}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent2 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch1'][$weekdaynumber]->komponent2}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent3 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch1'][$weekdaynumber]->komponent3}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent4 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch1'][$weekdaynumber]->komponent4}}</th>
                                    @endif

                                    @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent1 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch2'][$weekdaynumber]->komponent1}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent2 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch2'][$weekdaynumber]->komponent2}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent3 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch2'][$weekdaynumber]->komponent3}}</th>
                                    @endif
                                    @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent4 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Lunch2'][$weekdaynumber]->komponent4}}</th>
                                    @endif

                                    @if($chosen_courses['Middag'][$weekdaynumber]->komponent1 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Middag'][$weekdaynumber]->komponent1}}</th>
                                    @endif
                                    @if($chosen_courses['Middag'][$weekdaynumber]->komponent2 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Middag'][$weekdaynumber]->komponent2}}</th>
                                    @endif
                                    @if($chosen_courses['Middag'][$weekdaynumber]->komponent3 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Middag'][$weekdaynumber]->komponent3}}</th>
                                    @endif
                                    @if($chosen_courses['Middag'][$weekdaynumber]->komponent4 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Middag'][$weekdaynumber]->komponent4}}</th>
                                    @endif

                                    @if($chosen_courses['Dessert'][$weekdaynumber]->komponent1 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Dessert'][$weekdaynumber]->komponent1}}</th>
                                    @endif
                                    @if($chosen_courses['Dessert'][$weekdaynumber]->komponent2 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Dessert'][$weekdaynumber]->komponent2}}</th>
                                    @endif
                                    @if($chosen_courses['Dessert'][$weekdaynumber]->komponent3 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Dessert'][$weekdaynumber]->komponent3}}</th>
                                    @endif
                                    @if($chosen_courses['Dessert'][$weekdaynumber]->komponent4 != 'Ingenting')
                                        <th scope="col">{{$chosen_courses['Dessert'][$weekdaynumber]->komponent4}}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($sdns as $sdn)
                                    <tr>
                                        <th scope="row">{{$sdn->Specialkost}}</th>

                                        @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent1 != 'Ingenting')
                                            <input name="Lunch1[{{$weekdaynumber}}][komponent1][{{$sdn->Specialkost}}]" value="0" type="hidden">
                                            <td><input name="Lunch1[{{$weekdaynumber}}][komponent1][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent2 != 'Ingenting')
                                            <td><input name="Lunch1[{{$weekdaynumber}}][komponent2][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent3 != 'Ingenting')
                                            <td><input name="Lunch1[{{$weekdaynumber}}][komponent3][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch1'][$weekdaynumber]->komponent4 != 'Ingenting')
                                            <td><input name="Lunch1[{{$weekdaynumber}}][komponent4][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif

                                        @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent1 != 'Ingenting')
                                            <td><input name="Lunch2[{{$weekdaynumber}}][komponent1][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent2 != 'Ingenting')
                                            <td><input name="Lunch2[{{$weekdaynumber}}][komponent2][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent3 != 'Ingenting')
                                            <td><input name="Lunch2[{{$weekdaynumber}}][komponent3][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Lunch2'][$weekdaynumber]->komponent4 != 'Ingenting')
                                            <td><input name="Lunch2[{{$weekdaynumber}}][komponent4][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif

                                        @if($chosen_courses['Middag'][$weekdaynumber]->komponent1 != 'Ingenting')
                                            <td><input name="Middag[{{$weekdaynumber}}][komponent1][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Middag'][$weekdaynumber]->komponent2 != 'Ingenting')
                                            <td><input name="Middag[{{$weekdaynumber}}][komponent2][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Middag'][$weekdaynumber]->komponent3 != 'Ingenting')
                                            <td><input name="Middag[{{$weekdaynumber}}][komponent3][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Middag'][$weekdaynumber]->komponent4 != 'Ingenting')
                                            <td><input name="Middag[{{$weekdaynumber}}][komponent4][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif

                                        @if($chosen_courses['Dessert'][$weekdaynumber]->komponent1 != 'Ingenting')
                                            <td><input name="Dessert[{{$weekdaynumber}}][komponent1][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Dessert'][$weekdaynumber]->komponent2 != 'Ingenting')
                                            <td><input name="Dessert[{{$weekdaynumber}}][komponent2][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Dessert'][$weekdaynumber]->komponent3 != 'Ingenting')
                                            <td><input name="Dessert[{{$weekdaynumber}}][komponent3][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif
                                        @if($chosen_courses['Dessert'][$weekdaynumber]->komponent4 != 'Ingenting')
                                            <td><input name="Dessert[{{$weekdaynumber}}][komponent4][{{$sdn->Specialkost}}]" value="1" type="checkbox"></td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>

        @endforeach
    </div>

    <br>

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Skapa pdf för etikettutskrift</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
