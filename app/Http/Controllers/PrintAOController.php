<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuAO;
use App\Models\Course;
use App\Models\SpecialDietNeedAO;
use App\Models\OrderAO;
use App\Models\DepartmentAO;
use PDF;

class PrintAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
        $this->formatter = new \IntlDateFormatter('sv_SE', pattern: 'EEEE d MMM');
    }

    private $formatter;

    public function index(Request $request)
    {
        $prechosen_week = date("W", strtotime("1 week"));

        $weeks = [];
        for ($i=0; $i < 6; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'prechosen_week' => $prechosen_week,
            'departments' => DepartmentAO::orderBy('Namn')->get(),
        ];

        return view('print_ao.index')->with($data);
    }

    public function choose(Request $request)
    {
        $year = date("Y");
        $week = $request->week;
        $error = null;
        $warning = '';

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
                //$chosen_courses['Lunch1'][$i] = Course::makeEmpty();
                //$chosen_courses['Lunch2'][$i] = Course::makeEmpty();
                //$chosen_courses['Middag'][$i] = Course::makeEmpty();
                //$chosen_courses['Dessert'][$i] = Course::makeEmpty();
                $error = 'Matsedel f??r denna vecka saknas!';
            }
            $dates[$i] = $dateTime;
        }

        foreach(DepartmentAO::all() as $department) {
            if(OrderAO::where('Datum', $dateTime->format('Y-m-d'))->where('Avdelningar_AO_id', $department->id)->doesntExist()) {
                $warning .= $department->Namn.'<br>';
            }
        }
        if($warning != '') {
            $warning = 'Best??llning saknas ifr??n f??ljande avdelningar:<br>'.$warning;
        }

        $weekdays = [
            1 => 'M??ndag',
            2 => 'Tisdag',
            3 => 'Onsdag',
            4 => 'Torsdag',
            5 => 'Fredag',
            6 => 'L??rdag',
            7 => 'S??ndag'
        ];

        $sdns = SpecialDietNeedAO::select('Specialkost')->distinct()->get();

        $data = [
            'weekdays' => $weekdays,
            'chosen_courses' => $chosen_courses,
            'dates' => $dates,
            'sdns' => $sdns,
            'week' => $week,
            'error' => $error,
            'warning' => $warning,
        ];
        return view('print_ao.choose')->with($data);
    }

    private function make_label($weekday, $meal, $component, $dayorders, &$labels, $cc, $dateTime, $request, $department)
    {
        $objname = $meal."_object";
        $compname = "komponent".$component;
        $normalamount = $dayorders->$meal;
        //F??r den h??r komponenten, g?? ??ver alla relevanta bockar
        if(isset($request->$meal[$weekday]) && isset($request->$meal[$weekday][$compname])) {
            foreach($request->$meal[$weekday][$compname] as $dietname => $enabled) {
                $dietneed = $department->special_diet_needs->where('Specialkost', $dietname)->first();
                if(isset($dietneed)) {
                    $dietamount = $dietneed->Antal;
                    if($enabled) {
                        //??r en bock true, skapa en label f??r den
                        $labels->push([
                            'date' => $this->formatter->format($dateTime),
                            'sortdate' => $dateTime->format('Y-m-d'),
                            'amount' => $dietamount,
                            'department' => $dayorders->department->Namn,
                            'course' => $meal.': '.$cc->$objname->Namn,
                            'comp' => $cc->$objname->$compname,
                            'diet' => $dietname
                        ]);
                    } else {
                        //??r en bock false, r??kna p?? det antalet p?? normalkosten
                        $normalamount += $dietamount;
                    }
                }
            }
        }
        if(!is_null($cc) && !is_null($cc->$objname) && !is_null($cc->$objname->$compname) && $cc->$objname->$compname != 'Ingenting' && $normalamount > 0) {
            $labels->push([
                'date' => $this->formatter->format($dateTime),
                'sortdate' => $dateTime->format('Y-m-d'),
                'amount' => $normalamount,
                'department' => $dayorders->department->Namn,
                'course' => $meal.': '.$cc->$objname->Namn,
                'comp' => $cc->$objname->$compname,
                'diet' => ''
            ]);
        }

    }

    private function print_day($year, $week, $weekday, $request, &$labels)
    {
        $dateTime=new \DateTime();
        $dateTime->setISODate($year, $week, $weekday);

        $cc = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();

        //...f??r varje avdelning...
        foreach(DepartmentAO::all() as $department) {
            $dayorders = OrderAO::where('Datum', $dateTime->format('Y-m-d'))->where('Avdelningar_AO_id', $department->id)->first();

            if(isset($dayorders)) {

                //..f??r varje m??ltid...
                foreach(array('Lunch1', 'Lunch2', 'Middag', 'Dessert') as $meal) {
                    if(isset($dayorders->$meal) && $dayorders->$meal > 0) {
                        //...och f??r varje komponent i den m??ltiden
                        for($component=1; $component <= 4; $component++) {
                            $this->make_label($weekday, $meal, $component, $dayorders, $labels, $cc, $dateTime, $request, $department);
                        }
                    }    
                }
            }
        }
    }

    public function print(Request $request)
    {
        $year = date("Y");
        $week = $request->week;

        $labels = collect();
        if($request->action == 'fullweek') {
            $filename = 'Etiketter vecka '.$week.'.pdf';
            //F??r varje dag i veckan...
            for($weekday=1; $weekday <= 7; $weekday++) {
                $this->print_day($year, $week, $weekday, $request, $labels);
            }
        } else {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $week, $request->action);
            $filename = 'Etiketter '.$dateTime->format('Y-m-d').'.pdf';
            $this->print_day($year, $week, $request->action, $request, $labels);
        }

        $data = [
            'labels' => $labels->sortBy([
                ['sortdate', 'asc'],
                ['course', 'asc'],
                ['comp', 'asc'],
                ['diet', 'asc'],
            ]),
        ];

        //return view('print_ao.pdf')->with($data);

        $pdf = PDF::loadView('print_ao.pdf', $data);

        return $pdf->download($filename);
    }
}
