@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Välj vilken kund du vill redigera.</div>
                
                <div class="card-body">
                    <select class="custom-select d-block w-100" id="customer" name="customer" required="">
                        <option selected disabled>Välj kund</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->Namn}}</option>
                        @endforeach
                    </select>

                    <br>

                    <a href="/customer/create" class="btn btn-primary">Lägg till ny kund</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#customer').on('change', function (e) {
        var course_id = $('#customer').val();
        window.location='/customer/' + course_id + '/edit';
    });
</script>

@endsection
