@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Ange uppgifter nedan.</div>
                
                <div class="card-body">
                    <form method="post" action="{{action('CourseController@update', $course->id)}}" accept-charset="UTF-8">
                        @method('put')
                        @csrf

                        <div class="form-row">
                            <div class="col-9">
                                <label for="name">Namn</label>
                                <input name="name" class="form-control" value="{{$course->Namn}}">
                            </div>
                            <div class="col">
                                <br>
                                <input type="hidden" name="vego" value="0">
                                <label><input type="checkbox" name="vego" value="1" {{$course->Specialkost=='Vegetarisk'?"checked":""}}>Vegetarisk</label>
                            </div>
                        </div>

                        <br>

                        <div class="mb-5">
                            <label for="ingredients">Ingredienser</label>
                            <textarea rows=5 name="ingredients" class="form-control">{{$course->Ingredienser}}</textarea>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-9">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Spara</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-lg btn-danger btn-block" onclick="delete_course()">Radera</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function delete_course() {
        if(confirm('Vill du verkligen radera denna maträtt?')) {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '/course/{{$course->id}}',
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
