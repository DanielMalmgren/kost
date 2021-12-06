@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välj vilken maträtt du vill redigera.</div>
                
                <div class="card-body">
                    <select class="custom-select d-block w-100" id="course" name="course" required="">
                        <option selected disabled>Välj maträtt</option>
                        @foreach($courses as $course)
                            <option value="{{$course->id}}">{{$course->namn}}</option>
                        @endforeach
                    </select>

                    <br>

                    <a href="/course_ao/create" class="btn btn-primary">Lägg till ny maträtt</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#course').on('change', function (e) {
        var course_id = $('#course').val();
        window.location='/course_ao/' + course_id + '/edit';
    });
</script>

@endsection
