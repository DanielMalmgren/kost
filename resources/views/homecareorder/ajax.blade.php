<form method="post" name="question" action="{{action('HomeCareOrderController@store')}}" accept-charset="UTF-8">
    @csrf

    <input type="hidden" id="week" name="week" value="{{$week}}">
    <input type="hidden" name="menu" value="{{$menu}}">
    <input type="hidden" name="specialkost" value="{{$specialkost}}">
    <input type="hidden" name="customer_id" value="{{$customer->id}}">

    Grupp: {{$customer->group->Namn}} 

    @if($specialkost != '')
        Specialkost: {{$specialkost}}
    @endif

    <br><br>

    @for ($i = 1; $i <= 8; $i++)
        @if(isset($chosen_courses[$i]))
            <label for="alt[{{$i}}]" data-toggle="modal" data-target="#ingredients{{$i}}">Alternativ {{$i}} ({{$chosen_courses[$i]->Namn}})</label>

            <div class="modal fade" id="ingredients{{$i}}" tabindex="-1" role="dialog" aria-labelledby="ingredients{{$i}}Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ingredients{{$i}}Label">{{$chosen_courses[$i]->Namn}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{$chosen_courses[$i]->course->Ingredienser}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
                    </div>
                    </div>
                </div>
            </div>
        @else
            <label for="alt[{{$i}}]">Alternativ {{$i}} (Matsedel inte lagd än)</label>
        @endif

        <select class="custom-select d-block w-100" name="amount[{{$i}}]" required="">
            @for ($j = 0; $j <= 9; $j++)
                <option {{$ordered_amount[$i]==$j?"selected":""}}>{{$j}}</option>
            @endfor
        </select>
        <br>

    @endfor

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
