<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th scope="col">Namn</th>
            <th scope="col">Antal portioner</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order['name']}} ({{$order['personnr']}})</td>
                <td>{{$order['amount']}}</td>
            </tr>
            @endforeach
    </tbody>

</table>
