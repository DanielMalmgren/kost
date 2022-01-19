<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentAO;
use App\Models\MenuAO;

class OrderAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    //TODO: Completely remove index, just for demonstration purposes
    public function index(Request $request)
    {
        $data = [
        ];

        return view('order_ao.index')->with($data);
    }

    public function create(Request $request)
    {
        $prechosen_week = date("W", strtotime("2 week"));

        $weeks = [];
        for ($i=0; $i < 12; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'prechosen_week' => $prechosen_week,
            'departments' => DepartmentAO::orderBy('Namn')->get(),
        ];

        return view('order_ao.create')->with($data);
    }

    public function ajax(Request $request)
    {
        $department = DepartmentAO::find($request->department);

        $user = session()->get('user');
        if($user->isKost) {
            $too_late = false;
            $almost_too_late = false;
        } else {
            $too_late = $request->week < date("W", strtotime("2 week"));
            $almost_too_late = $request->week == date("W", strtotime("2 week")) && date("N") >= 4;
        }

        $current_week = date("W");
        if($request->week >= $current_week) {
            $year = date("Y");
        } else {
            $year = date("Y")+1;
        }

        $dates = [];
        $chosen_courses = [];
        $chosen_courses['Lunch1'] = [];
        $chosen_courses['Lunch2'] = [];
        $chosen_courses['Middag'] = [];
        $chosen_courses['Dessert'] = [];
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $request->week, $i);
            $cc = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();
            if($cc !== null) {
                if($cc->Lunch1 == -1) {
                    $chosen_courses['Lunch1'][$i] = 'Ingen matsedel lagd';
                } else {
                    $chosen_courses['Lunch1'][$i] = $cc->Lunch1_object->Namn;
                }
                if($cc->Lunch2 == -1) {
                    $chosen_courses['Lunch2'][$i] = 'Ingen matsedel lagd';
                } else {
                    $chosen_courses['Lunch2'][$i] = $cc->Lunch2_object->Namn;
                }
                if($cc->Middag == -1) {
                    $chosen_courses['Middag'][$i] = 'Ingen matsedel lagd';
                } else {
                    $chosen_courses['Middag'][$i] = $cc->Middag_object->Namn;
                }
                if($cc->Dessert == -1) {
                    $chosen_courses['Dessert'][$i] = 'Ingen matsedel lagd';
                } else {
                    $chosen_courses['Dessert'][$i] = $cc->Dessert_object->Namn;
                }
            } else {
                $chosen_courses['Lunch1'][$i] = 'Ingen matsedel lagd';
                $chosen_courses['Lunch2'][$i] = 'Ingen matsedel lagd';
                $chosen_courses['Middag'][$i] = 'Ingen matsedel lagd';
                $chosen_courses['Dessert'][$i] = 'Ingen matsedel lagd';
            }
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
            'week' => $request->week,
            'department' => $department,
            'too_late' => $too_late,
            'almost_too_late' => $almost_too_late,
            'weekdays' => $weekdays,
            'dates' => $dates,
            'chosen_courses' => $chosen_courses,
        ];
        return view('order_ao.ajax')->with($data);
    }

    public function store(Request $request)
    {
        $department = DepartmentAO::find($request->department_id);

        /*HomeCareOrder::updateOrCreate(
            [
                'Vecka' => $request->week,
                'Specialkost' => $request->specialkost,
                'Kund_id' => $customer->id,
            ],
            [
                'Kund_namn' => $customer->Namn, 
                'Kund_personnr' => $customer->Personnr, 
                'Grupp' => $customer->grupp_id, 
                'Bestdatum' => date("Y-m-d"), 
                'Bestallare' => 'ITSAM\\'.session()->get('user')->username,
                'Alt1' => $request->amount[1],
                'Alt2' => $request->amount[2],
                'Alt3' => $request->amount[3],
                'Alt4' => $request->amount[4],
                'Alt5' => $request->amount[5],
                'Alt6' => $request->amount[6],
                'Alt7' => $request->amount[7],
                'Alt8' => $request->amount[8],
            ]
        );*/

        return redirect('/order_ao/create')->with('success', 'Beställningen har sparats');
    }

}
