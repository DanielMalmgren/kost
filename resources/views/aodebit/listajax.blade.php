<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th scope="col">Avdelning</th>
            <th scope="col">Luncher</th>
            <th scope="col">Middagar</th>
            <th scope="col">Totalt</th>
        </tr>
    </thead>
    <tbody>
        @php
            $lunches_total = 0;
            $dinners_total = 0;
        @endphp
        @foreach($departments as $department)
            @php
                $lunches = $department->lunches($year, $month);
                $dinners = $department->dinners($year, $month);
                $lunches_total += $lunches;
                $dinners_total += $dinners;
            @endphp
            <tr>
                <td>{{$department->Namn}}</td>
                <td>{{$lunches}}</td>
                <td>{{$dinners}}</td>
                <td>{{$lunches+$dinners}}</td>
            </tr>
            @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>{{$lunches_total}}</th>
            <th>{{$dinners_total}}</th>
            <th>{{$lunches_total+$dinners_total}}</th>
        </tr>
    </thead>

</table>

<a href="/aodebit/gsheet?month={{$month}}&year={{$year}}" class="btn btn-primary">Skapa kalkylark</a>
