@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välj vilken avdelning du vill redigera.</div>
                
                <div class="card-body">
                    <select class="custom-select d-block w-100" id="department" name="department" required="">
                        <option selected disabled>Välj avdelning</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->Namn}}</option>
                        @endforeach
                    </select>

                    <br>

                    <a href="/department_ao/create" class="btn btn-primary">Lägg till ny avdelning</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#department').on('change', function (e) {
        var department_id = $('#department').val();
        window.location='/department_ao/' + department_id + '/edit';
    });
</script>

@endsection
