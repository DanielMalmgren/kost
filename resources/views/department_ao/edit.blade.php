@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('DepartmentAOController@update', $department->id)}}" accept-charset="UTF-8">
                        @method('put')
                        @csrf

                        <div class="mb-5">
                            <label for="name">Namn</label>
                            <input required name="namn" class="form-control" value="{{old('namn', $department->Namn)}}">
                        </div>

                        <div class="mb-5">
                            <label for="name">Antal boende</label>
                            <input type="number" min="0" name="boende" class="form-control" value="{{old('boende', $department->Boende)}}">
                        </div>

                        <label>Specialkostbehov</label>
                        @foreach($special_diets as $special_diet)
                            @php
                                $special_diet_need = $department->special_diet_needs->where('Specialkost_AO_id', $special_diet->id)->first();
                                if($special_diet_need == null) {
                                    $antal = 0;
                                } else {
                                    $antal = $special_diet_need->Antal;
                                }
                            @endphp
                            <div class="form-row">
                                <div class="col-4">
                                    <label>{{$special_diet->Namn}}</label>
                                </div>
                                <div class="col-2">
                                    <input type="number" min="0" name="special_diets[{{$special_diet->id}}]" class="form-control" value="{{$antal}}">
                                </div>
                            </div>
                        @endforeach

                        <br>

                        <div class="form-row">
                            <div class="col-9">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-lg btn-danger btn-block" onclick="delete_department()">Radera</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function delete_department() {
        if(confirm('Vill du verkligen radera denna avdelning?')) {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '/department_ao/{{$department->id}}',
                data : {_token:token},
                type: 'DELETE',
                success: function(result) {
                    console.log(result)
                }
            })
            .always(function() {
                window.location='/';
            });
        }
    }

</script>


@endsection
