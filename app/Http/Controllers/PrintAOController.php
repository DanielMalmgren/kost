<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $year = date("Y");
        $week = date("W");

        $dates = [];
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $week, $i);
            $dates[$i] = $dateTime;
        }

        $weekdays = [
            1 => 'Måndag',
            2 => 'Tisdag',
            3 => 'Onsdag',
            4 => 'Torsdag',
            5 => 'Fredag',
            6 => 'Lördag',
            7 => 'Söndag'
        ];

        $data = [
            'weekdays' => $weekdays,
            'dates' => $dates,
        ];
        return view('print_ao.index')->with($data);
    }

    public function print(Request $request)
    {
        //
    }
}
