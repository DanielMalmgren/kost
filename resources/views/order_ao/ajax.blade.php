<script type="text/javascript">
    function updateTotal(classname) {
        const collection = document.getElementsByClassName(classname);
        var total = 0;
        for (let i = 0; i < collection.length; i++) {
            total += parseInt(collection[i].value);
        }
        sumfield = document.getElementById(classname);
        sumfield.value = total;
    }
</script>

<form method="post" name="question" action="{{action('OrderAOController@store')}}" accept-charset="UTF-8">
    @csrf

    <input type="hidden" id="week" name="week" value="{{$week}}">
    <input type="hidden" id="year" name="year" value="{{$year}}">
    <input type="hidden" name="department_id" value="{{$department->id}}">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach($weekdays as $weekdaynumber => $weekday)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{$weekdaynumber==1?'active':''}}" id="{{$weekdaynumber}}-tab" data-toggle="tab" href="#tab{{$weekdaynumber}}" role="tab" aria-controls="{{$weekdaynumber}}">{{$weekday}}<br>{{$dates[$weekdaynumber]->format('j/n')}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach($weekdays as $weekdaynumber => $weekday)

            @php
                $existing = App\Models\OrderAO::where('Datum', $dates[$weekdaynumber]->format('Y-m-d'))->where('Avdelningar_AO_id', $department->id)->first();
                if(empty($existing)) {
                    $normalkost = $department->Boende - $department->special_diet_needs->sum('Antal');
                    $lunch1 = $normalkost;
                    $lunch2 = 0;
                    $middag = $normalkost;
                    $dessert = $normalkost;
                    $id=-$weekdaynumber;
                    $newOrder = true;
                } else {
                    $lunch1 = $existing->Lunch1;
                    $lunch2 = $existing->Lunch2;
                    $middag = $existing->Middag;
                    $dessert = $existing->Dessert;
                    $id=$existing->id;
                    $newOrder = false;
                }
            @endphp

            <input type="hidden" name="id[{{$weekdaynumber}}]" value="{{$id}}">

            <div class="tab-pane fade {{$weekdaynumber==1?'show active':''}}" id="tab{{$weekdaynumber}}" role="tabpanel" aria-labelledby="{{$weekdaynumber}}-tab">
            
                <br>

                @if($department->Lunch)
            
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-header">Lunch 1: {{$chosen_courses['Lunch1'][$weekdaynumber]}}</div>

                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Normalkost</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" min="0" max="{{$department->Boende}}" name="Lunch1[{{$weekdaynumber}}]" class="form-control Lunch1_{{$weekdaynumber}}" value="{{$lunch1}}" onChange="updateTotal('Lunch1_{{$weekdaynumber}}')">
                                            </div>
                                        </div>

                                        @if($department->special_diet_needs->isNotEmpty())
                                            @foreach($department->special_diet_needs as $special_diet_need)

                                                @php
                                                    $existingdiet = App\Models\OrderDietAO::where('Order_AO_id', $id)->where('Namn', $special_diet_need->Specialkost)->first();
                                                    if(empty($existingdiet)) {
                                                        if($newOrder) {
                                                            $thisdiet = $special_diet_need->Antal;
                                                        } else {
                                                            $thisdiet = 0;
                                                        }
                                                    } else {
                                                        $thisdiet = $existingdiet->Lunch1;
                                                    }
                                                @endphp

                                                <div class="form-row">
                                                    <div class="col-8">
                                                        <label>{{$special_diet_need->Specialkost}}</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" min="0" max="{{$special_diet_need->Antal}}" name="diet[{{$id}}][{{$special_diet_need->Specialkost}}][Lunch1]" class="form-control Lunch1_{{$weekdaynumber}}" value="{{$thisdiet}}" onChange="updateTotal('Lunch1_{{$weekdaynumber}}')">
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Totalt</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" readonly id="Lunch1_{{$weekdaynumber}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-header">Lunch 2: {{$chosen_courses['Lunch2'][$weekdaynumber]}}</div>

                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Normalkost</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" min="0" max="{{$department->Boende}}" name="Lunch2[{{$weekdaynumber}}]" class="form-control Lunch2_{{$weekdaynumber}}" value="{{$lunch2}}" onChange="updateTotal('Lunch2_{{$weekdaynumber}}')">
                                            </div>
                                        </div>

                                        @if($department->special_diet_needs->isNotEmpty())
                                            @foreach($department->special_diet_needs as $special_diet_need)

                                                @php
                                                    $existingdiet = App\Models\OrderDietAO::where('Order_AO_id', $id)->where('Namn', $special_diet_need->Specialkost)->first();
                                                    if(empty($existingdiet)) {
                                                        $thisdiet = 0;
                                                    } else {
                                                        $thisdiet = $existingdiet->Lunch2;
                                                    }
                                                @endphp

                                                <div class="form-row">
                                                    <div class="col-8">
                                                        <label>{{$special_diet_need->Specialkost}}</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" min="0" max="{{$special_diet_need->Antal}}" name="diet[{{$id}}][{{$special_diet_need->Specialkost}}][Lunch2]" class="form-control Lunch2_{{$weekdaynumber}}" value="{{$thisdiet}}" onChange="updateTotal('Lunch2_{{$weekdaynumber}}')">
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Totalt</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" readonly id="Lunch2_{{$weekdaynumber}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <input type="hidden" name="Lunch1[{{$weekdaynumber}}]" value="0">
                        <input type="hidden" name="Lunch2[{{$weekdaynumber}}]" value="0">
                    @endif

                    <br>

                    <div class="row justify-content-center">

                        @if($department->Middag)

                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-header">Middag: {{$chosen_courses['Middag'][$weekdaynumber]}}</div>

                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Normalkost</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" min="0" max="{{$department->Boende}}" name="Middag[{{$weekdaynumber}}]" class="form-control Middag_{{$weekdaynumber}}" value="{{$middag}}" onChange="updateTotal('Middag_{{$weekdaynumber}}')">
                                            </div>
                                        </div>

                                        @if($department->special_diet_needs->isNotEmpty())
                                            @foreach($department->special_diet_needs as $special_diet_need)

                                                @php
                                                    $existingdiet = App\Models\OrderDietAO::where('Order_AO_id', $id)->where('Namn', $special_diet_need->Specialkost)->first();
                                                    if(empty($existingdiet)) {
                                                        if($newOrder) {
                                                            $thisdiet = $special_diet_need->Antal;
                                                        } else {
                                                            $thisdiet = 0;
                                                        }
                                                    } else {
                                                        $thisdiet = $existingdiet->Middag;
                                                    }
                                                @endphp

                                                <div class="form-row">
                                                    <div class="col-8">
                                                        <label>{{$special_diet_need->Specialkost}}</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" min="0" max="{{$special_diet_need->Antal}}" name="diet[{{$id}}][{{$special_diet_need->Specialkost}}][Middag]" class="form-control Middag_{{$weekdaynumber}}" value="{{$thisdiet}}" onChange="updateTotal('Middag_{{$weekdaynumber}}')">
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Totalt</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" readonly id="Middag_{{$weekdaynumber}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @else
                            <input type="hidden" name="Middag[{{$weekdaynumber}}]" value="0">
                        @endif

                        <div class="col-md-6">
                            @if($weekdaynumber==4 || $weekdaynumber==6 || $weekdaynumber==7)

                                <div class="card">
                                    <div class="card-header">Dessert: {{$chosen_courses['Dessert'][$weekdaynumber]}}</div>

                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Normalkost</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" min="0" max="{{$department->Boende}}" name="Dessert[{{$weekdaynumber}}]" class="form-control Dessert_{{$weekdaynumber}}" value="{{$dessert}}" onChange="updateTotal('Dessert_{{$weekdaynumber}}')">
                                            </div>
                                        </div>

                                        @if($department->special_diet_needs->isNotEmpty())
                                            @foreach($department->special_diet_needs as $special_diet_need)

                                            @php
                                                $existingdiet = App\Models\OrderDietAO::where('Order_AO_id', $id)->where('Namn', $special_diet_need->Specialkost)->first();
                                                if(empty($existingdiet) || is_null($existingdiet->Dessert)) {
                                                    if($newOrder) {
                                                        $thisdiet = $special_diet_need->Antal;
                                                    } else {
                                                        $thisdiet = 0;
                                                    }
                                                } else {
                                                    $thisdiet = $existingdiet->Dessert;
                                                }
                                            @endphp

                                                <div class="form-row">
                                                    <div class="col-8">
                                                        <label>{{$special_diet_need->Specialkost}}</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" min="0" max="{{$special_diet_need->Antal}}" name="diet[{{$id}}][{{$special_diet_need->Specialkost}}][Dessert]" class="form-control Dessert_{{$weekdaynumber}}" value="{{$thisdiet}}" onChange="updateTotal('Dessert_{{$weekdaynumber}}')">
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                        <div class="form-row">
                                            <div class="col-8">
                                                <label>Totalt</label>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" readonly id="Dessert_{{$weekdaynumber}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            
            </div>

            <script type="text/javascript">
                updateTotal('Lunch1_{{$weekdaynumber}}');
                updateTotal('Lunch2_{{$weekdaynumber}}');
                updateTotal('Middag_{{$weekdaynumber}}');
                @if($weekdaynumber==4 || $weekdaynumber==6 || $weekdaynumber==7)
                    updateTotal('Dessert_{{$weekdaynumber}}');
                @endif
            </script>

        @endforeach
    </div>

    <br>

    @if($almost_too_late)
        <div style="border-color:red;border-width:5px;border-style:solid;border-radius:0.3rem;padding-left:10px;font-size:1.5rem">
            Denna beställning inkommer efter brytdatum.<br>
            Det innebär att du själv måste kontakta köket och meddela dem om avvikelse!
        </div>
        <br>
    @endif

    <button {{$too_late?"disabled":""}} class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">Spara</button>
</form>
