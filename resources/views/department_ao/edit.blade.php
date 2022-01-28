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
                        @foreach($special_diet_needs as $special_diet_need)
                            <div class="form-row">
                                <div class="col-5">
                                    <input name="special_diet[{{$special_diet_need->id}}][name]" class="form-control" value="{{$special_diet_need->Specialkost}}">
                                </div>
                                <div class="col-2">
                                    <input type="number" min="0" name="special_diet[{{$special_diet_need->id}}][amount]" class="form-control" value="{{$special_diet_need->Antal}}">
                                </div>
                            </div>
                        @endforeach
                        <div class="form-row">
                            <div class="col-5">
                                <input name="new_special_diet[1][name]" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" min="0" name="new_special_diet[1][amount]" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                <input name="new_special_diet[2][name]" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" min="0" name="new_special_diet[2][amount]" class="form-control" value="0">
                            </div>
                        </div>

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
