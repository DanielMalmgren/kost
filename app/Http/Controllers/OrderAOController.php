<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentAO;
use App\Models\MenuAO;
use App\Models\OrderAO;
use App\Models\OrderDietAO;

class OrderAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    //TODO: Completely remove index, just for demonstration purposes
    /*public function index(Request $request)
    {
        $data = [
        ];

        return view('order_ao.index')->with($data);
    }*/

    public function create(Request $request)
    {
        $prechosen_week = date("W", strtotime("2 week"));

        $user = session()->get('user');
        if($user->isKost) {
            $startweek = -6;
        } else {
            $startweek = 0;
        }

        $weeks = [];
        for ($i=$startweek; $i < 12; $i++) { 
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
            $too_late = ($request->week < date("W", strtotime("2 week"))) && !($request->week+20 < date("W"));
            $almost_too_late = $request->week == date("W", strtotime("2 week")) && date("N") >= 4;
        }

        $current_week = date("W");
        if($current_week > 40 && $request->week < 15) {
            $year = date("Y")+1;
        } elseif($current_week < 15 && $request->week > 40) {
            $year = date("Y")-1;
        } else {
            $year = date("Y");
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
                //TODO!!! Se till att sätta vettiga withDefault-värden på MenuAO istället!
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

        if($department->Helg) {
            $weekdays = [
                1 => 'Måndag',
                2 => 'Tisdag',
                3 => 'Onsdag',
                4 => 'Torsdag',
                5 => 'Fredag',
                6 => 'Lördag',
                7 => 'Söndag'
            ];
        } else {
            $weekdays = [
                1 => 'Måndag',
                2 => 'Tisdag',
                3 => 'Onsdag',
                4 => 'Torsdag',
                5 => 'Fredag'
            ];            
        }

        $data = [
            'week' => $request->week,
            'year' => $year,
            'department' => $department,
            'too_late' => $too_late,
            'almost_too_late' => $almost_too_late,
            'weekdays' => $weekdays,
            'dates' => $dates,
            'chosen_courses' => $chosen_courses,
            'existing_orders' => OrderAO::all(),
        ];
        return view('order_ao.ajax')->with($data);
    }

    public function store(Request $request)
    {
        for($i=1; $i <= 7; $i++) {

            if(!isset($request->Lunch1[$i]) && !isset($request->Middag[$i])) {
                continue;
            }

            $dateTime=new \DateTime();
            $dateTime->setISODate($request->year, $request->week, $i);

            $order = OrderAO::updateOrCreate(
                [
                    'Datum' => $dateTime,
                    'Avdelningar_AO_id' => $request->department_id,
                ],
                [
                    'RegDatum' => date("Y-m-d"), 
                    'RegAv' => 'ITSAM\\'.session()->get('user')->username,
                    'Lunch1' => $request->Lunch1[$i],
                    'Lunch2' => $request->Lunch2[$i],
                    'Middag' => $request->Middag[$i],
                    'Dessert' => isset($request->Dessert[$i])?$request->Dessert[$i]:-1,
                ]
            );

            if($order->wasRecentlyCreated) {
                $order_id = $request->id[$i];
            } else {
                $order_id = $order->id;
            }

            if($request->diet) {
                foreach($request->diet[$order_id] as $name => $amounts) {
                    OrderDietAO::updateOrCreate(
                        [
                            'Order_AO_id' => $order->id,
                            'Namn' => $name,
                        ],
                        [
                            'Lunch1' => isset($amounts['Lunch1'])?$amounts['Lunch1']:null,
                            'Lunch2' => isset($amounts['Lunch2'])?$amounts['Lunch2']:null,
                            'Middag' => isset($amounts['Middag'])?$amounts['Middag']:null,
                            'Dessert' => isset($amounts['Dessert'])?$amounts['Dessert']:null,
                        ]
                    );
                }
            }

        }

        return redirect('/order_ao/create')->with('success', 'Beställningen har sparats');
    }

}
