<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\MenuAO;
use PDF;

class MenuAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function edit(Request $request)
    {
        $current_week = date("W");

        $weeks = [];
        for ($i=0; $i < 12; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'current_week' => $current_week,
        ];
        return view('menu_ao.edit')->with($data);
    }

    public function ajax(Request $request)
    {
        $user = session()->get('user');

        date_default_timezone_set('Europe/Stockholm');
        setlocale(LC_ALL, 'sv_SE');
        \App::setLocale('sv_SE');

        $courses = Course::orderBy('Namn')->whereNotNull('komponent1')->where('Namn', '!=', 'Ingen matsedel lagd')->get();

        $current_week = date("W");
        if($request->week >= $current_week) {
            $year = date("Y");
        } else {
            $year = date("Y")+1;
        }

        $dates = [];
        $chosen_courses = [];
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $request->week, $i);
            $chosen_courses[$i] = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();
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
            'courses' => $courses,
            'chosen_courses' => $chosen_courses,
            'dates' => $dates,
            'weekdays' => $weekdays,
            'user' => $user,
        ];
        return view('menu_ao.ajax')->with($data);
    }

    public function update(Request $request)
    {
        for ($i=1; $i <= 7; $i++) {
            if(isset($request->lunch1[$i])) {
                $lunch1 = $request->lunch1[$i];
            } else {
                $lunch1 = -1;
            }
            if(isset($request->lunch2[$i])) {
                $lunch2 = $request->lunch2[$i];
            } else {
                $lunch2 = -1;
            }
            if(isset($request->middag[$i])) {
                $middag = $request->middag[$i];
            } else {
                $middag = -1;
            }
            if(isset($request->dessert[$i])) {
                $dessert = $request->dessert[$i];
            } else {
                $dessert = -1;
            }

            $menu = MenuAO::updateOrCreate(
                [
                    'Datum' => $request->date[$i],
                ],
                [
                    'Lunch1' => $lunch1,
                    'Lunch2' => $lunch2,
                    'Middag' => $middag,
                    'Dessert' => $dessert,
                    'RegAv' => 'ITSAM\\'.session()->get('user')->username,
                ]
            );

            $menu->RegDatum = date("Y-m-d");
            $menu->save();
        }

        return redirect('/')->with('success', 'Matsedeln har sparats');
    }

    public function pdf(Request $request)
    {
        date_default_timezone_set('Europe/Stockholm');
        setlocale(LC_ALL, 'sv_SE');
        \App::setLocale('sv_SE');

        $current_week = date("W");
        if($request->week >= $current_week) {
            $year = date("Y");
        } else {
            $year = date("Y")+1;
        }

        $dates = [];
        $chosen_courses = [];
        for($i=1; $i <= 7; $i++) {
            $dateTime=new \DateTime();
            $dateTime->setISODate($year, $request->week, $i);
            $chosen_courses[$i] = MenuAO::where('Datum', $dateTime->format('Y-m-d'))->first();
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
            'chosen_courses' => $chosen_courses,
            'dates' => $dates,
            'weekdays' => $weekdays,
        ];

        //return view('menu_ao.pdf')->with($data);

        $filename = 'Matsedel vecka '.$request->week.'.pdf';

        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ]
        ]);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($contxt);

        $pdf->loadView('menu_ao.pdf', $data);

        return $pdf->download($filename);
    }
}
