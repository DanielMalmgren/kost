<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\DepartmentAO;

class AODebitController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $months = [];
        for ($i=-6; $i <= 0; $i++) {
            $month = date("Y-m",strtotime($i." month",strtotime(date("Y-m-01",strtotime("now")))));
            $months[$month] = $month;
        }

        $data = [
            'months' => $months,
        ];
        return view('aodebit.index')->with($data);
    }

    public function listajax(Request $request)
    {
        $montharray = explode('-', $request->month);
        $data = [
            'departments' => DepartmentAO::orderBy('Namn')->get(),
            'year' => $montharray[0],
            'month' => $montharray[1],
        ];
        return view('aodebit.listajax')->with($data);
    }
}
