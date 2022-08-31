<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\HomeCareOrder;
use App\Models\HCLabel;
use App\Models\HCLabelSpec;
use App\Models\HCLabelVeg;
use PDF;

class PrintHCController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
        $this->formatter = new \IntlDateFormatter('sv_SE', pattern: 'EEEE d MMM');
    }

    private $formatter;

    public function index(Request $request)
    {
        return view('print_hc.index');
    }

    public function print(Request $request)
    {

        /*
        //Work in progress! För att kunna skicka med vecka i requesten och få det mer dynamiskt istället för att använda statiska databasvyer
        if($request->exists('week')) {
            $labels = collect();
            for($i=1; $i <= 8; $i++) {
                $course = Menu::where('Vecka', $request->week)->where('Alternativ', $i)->where('Specialkost', 'Normal')->first()->course;
                $labels->push([
                    'Alternativ' => $i,
                    'Namn' => $course->Namn,
                    'Ingredienser' => $course->Ingredienser,
                    'Antal' => HomeCareOrder::where('Vecka', $request->week)->whereNull('Specialkost')->sum('Alt'.$i)
                ]);
            }

            logger(print_r($labels, true));
        }
        */

        if($request->type == 'spec') {
            $labels = HCLabelSpec::all();
        } elseif ($request->type == 'test') {
            $labels = HCLabel::all();
        } else {
            if($request->type == 'veg') {
                $labels = HCLabelVeg::all();
            } else {
                $labels = HCLabel::all();
            }
            foreach($labels as $label) {
                for ($i = 1; $i < $label->Antal; $i++) {
                    $labels->push($label->replicate());
                }
            }
        }

        if(date('w') == 0 || date('w') > 3) { //thursday-sunday
            $expiredate = date('Y-m-d', strtotime("next sunday") + 86400*14);
        } else { //monday-wednesday
            $expiredate = date('Y-m-d', strtotime("next sunday") + 86400*7);
        }

        logger("Totalt antal: ".$labels->count());

        $filename = 'Etiketter vecka '.date('W').'.pdf';

        $data = [
            'labels' => $labels->sortBy([
                ['Alternativ', 'asc'],
                ['Specialkost', 'asc'],
            ]),
            'expiredate' => $expiredate,
            'type' => $request->type,
        ];

        //return view('print_hc.pdf')->with($data);

        $contxt = stream_context_create([
            'ssl' => [
            'verify_peer' => FALSE,
            'verify_peer_name' => FALSE,
            'allow_self_signed'=> TRUE
            ]
        ]);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($contxt);

        $pdf->loadView('print_hc.pdf', $data);

        return $pdf->download($filename);
    }
}
