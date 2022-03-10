<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuAO;
use App\Models\Course;
use App\Models\SpecialDietNeedAO;
use App\Models\OrderAO;
use PDF;

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
        $chosen_courses = [];
        $chosen_courses['Lunch1'] = [];
        $chosen_courses['Lunch2'] = [];
        $chosen_courses['Middag'] = [];
        $chosen_courses['Dessert'] = [];
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $week, $i);
            $cc = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();
            if($cc !== null) {
                $chosen_courses['Lunch1'][$i] = $cc->Lunch1_object;
                $chosen_courses['Lunch2'][$i] = $cc->Lunch2_object;
                $chosen_courses['Middag'][$i] = $cc->Middag_object;
                $chosen_courses['Dessert'][$i] = $cc->Dessert_object;
            } else {
                $chosen_courses['Lunch1'][$i] = Course::createEmpty();
                $chosen_courses['Lunch2'][$i] = Course::createEmpty();
                $chosen_courses['Middag'][$i] = Course::createEmpty();
                $chosen_courses['Dessert'][$i] = Course::createEmpty();
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

        $sdns = SpecialDietNeedAO::select('Specialkost')->distinct()->get();

        $data = [
            'weekdays' => $weekdays,
            'chosen_courses' => $chosen_courses,
            'dates' => $dates,
            'sdns' => $sdns,
        ];
        return view('print_ao.index')->with($data);
    }

    public function print(Request $request)
    {
        $formatter = new \IntlDateFormatter('sv_SE', pattern: 'EEEE d MMM');

        $year = date("Y");
        $week = date("W");

        $labels = collect();
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $week, $i);

            $cc = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();

            $dayorders = OrderAO::where('Datum', $dateTime->format('Y-m-d'))->first();

            if($dayorders->Lunch1 > 0) {
                if(!is_null($cc->Lunch1_object->komponent1) && $cc->Lunch1_object->komponent1 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch1,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 1: '.$cc->Lunch1_object->Namn,
                        'comp' => $cc->Lunch1_object->komponent1,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch1_object->komponent2) && $cc->Lunch1_object->komponent2 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch1,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 1: '.$cc->Lunch1_object->Namn,
                        'comp' => $cc->Lunch1_object->komponent2,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch1_object->komponent3) && $cc->Lunch1_object->komponent3 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch1,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 1: '.$cc->Lunch1_object->Namn,
                        'comp' => $cc->Lunch1_object->komponent3,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch1_object->komponent4) && $cc->Lunch1_object->komponent4 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch1,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 1: '.$cc->Lunch1_object->Namn,
                        'comp' => $cc->Lunch1_object->komponent4,
                        'diet' => ''
                    ]);
                }
            }

            if($dayorders->Lunch2 > 0) {
                if(!is_null($cc->Lunch2_object->komponent1) && $cc->Lunch2_object->komponent1 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch2,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 2: '.$cc->Lunch2_object->Namn,
                        'comp' => $cc->Lunch2_object->komponent1,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch2_object->komponent2) && $cc->Lunch2_object->komponent2 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch2,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 2: '.$cc->Lunch2_object->Namn,
                        'comp' => $cc->Lunch2_object->komponent2,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch2_object->komponent3) && $cc->Lunch2_object->komponent3 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch2,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 2: '.$cc->Lunch2_object->Namn,
                        'comp' => $cc->Lunch2_object->komponent3,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Lunch2_object->komponent4) && $cc->Lunch2_object->komponent4 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Lunch2,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Lunch 2: '.$cc->Lunch2_object->Namn,
                        'comp' => $cc->Lunch2_object->komponent4,
                        'diet' => ''
                    ]);
                }
            }

            if($dayorders->Middag > 0) {
                if(!is_null($cc->Middag_object->komponent1) && $cc->Middag_object->komponent1 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Middag,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Middag: '.$cc->Middag_object->Namn,
                        'comp' => $cc->Middag_object->komponent1,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Middag_object->komponent2) && $cc->Middag_object->komponent2 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Middag,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Middag: '.$cc->Middag_object->Namn,
                        'comp' => $cc->Middag_object->komponent2,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Middag_object->komponent3) && $cc->Middag_object->komponent3 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Middag,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Middag: '.$cc->Middag_object->Namn,
                        'comp' => $cc->Middag_object->komponent3,
                        'diet' => ''
                    ]);
                }

                if(!is_null($cc->Middag_object->komponent4) && $cc->Middag_object->komponent4 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Middag,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Middag: '.$cc->Middag_object->Namn,
                        'comp' => $cc->Middag_object->komponent4,
                        'diet' => ''
                    ]);
                }
            }

            if(isset($dayorders->Dessert) && $dayorders->Dessert > 0) {
                if(!is_null($cc->Dessert_object->komponent1) && $cc->Dessert_object->komponent1 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Dessert,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Dessert: '.$cc->Dessert_object->Namn,
                        'comp' => $cc->Dessert_object->komponent1,
                        'diet' => ''
                    ]);
                }
    
                if(!is_null($cc->Dessert_object->komponent2) && $cc->Dessert_object->komponent2 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Dessert,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Dessert: '.$cc->Dessert_object->Namn,
                        'comp' => $cc->Dessert_object->komponent2,
                        'diet' => ''
                    ]);
                }
    
                if(!is_null($cc->Dessert_object->komponent3) && $cc->Dessert_object->komponent3 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Dessert,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Dessert: '.$cc->Dessert_object->Namn,
                        'comp' => $cc->Dessert_object->komponent3,
                        'diet' => ''
                    ]);
                }
    
                if(!is_null($cc->Dessert_object->komponent4) && $cc->Dessert_object->komponent4 != 'Ingenting') {
                    $labels->push([
                        'date' => $formatter->format($dateTime),
                        'amount' => $dayorders->Dessert,
                        'department' => $dayorders->department->Namn,
                        'course' => 'Dessert: '.$cc->Dessert_object->Namn,
                        'comp' => $cc->Dessert_object->komponent4,
                        'diet' => ''
                    ]);
                }    
            }
        }

        $data = [
            'labels' => $labels,
        ];

        //return view('print_ao.pdf')->with($data);

        $pdf = PDF::loadView('print_ao.pdf', $data);

        return $pdf->download('Etiketter vecka '.$week.'.pdf');
    }
}
