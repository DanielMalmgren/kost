<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Menu;
use App\Models\Recipe;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function edit(Request $request)
    {
        $current_week = date("W");

        $weeks = [];
        for ($i=-4; $i < 12; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'current_week' => $current_week,
        ];
        return view('menu.edit')->with($data);
    }

    public function ajax(Request $request)
    {
        if($request->type == 'Vegetarisk') {
            $type = 'Vegetarisk';
        } else {
            $type = 'Normal';
        }

        $courses = Course::orderBy('Namn')->where('Specialkost', $type)->where('Namn', '!=', '')->get();

        $chosen_courses = [];
        for ($i=1; $i <= 8; $i++) {
            $this_course = Menu::where('Vecka', $request->week)
                                ->where('Alternativ', $i)
                                ->where('Specialkost', $type)
                                ->first();
            if(isset($this_course)) {
                $chosen_courses[$i] = $this_course->Ingrediens_Id;
            } else {
                $chosen_courses[$i] = -1;
            }            
        }

        $data = [
            'week' => $request->week,
            'courses' => $courses,
            'chosen_courses' => $chosen_courses,
            'type' => $type,
        ];
        return view('menu.ajax')->with($data);
    }

    public function update(Request $request)
    {

        for ($i=1; $i <= 8; $i++) {
            if(isset($request->alt[$i])) {
                $recipe = Recipe::find($request->alt[$i]);

                $menu = Menu::updateOrCreate(
                    ['Vecka' => $request->week,
                    'Alternativ' => $i,
                    'Specialkost' => $request->type],
                    ['Namn' => $recipe->Namn,
                    'RegAv' => 'ITSAM\\'.session()->get('user')->username,
                    'Ingrediens_Id' => $request->alt[$i],]
                );

                $menu->RegDatum = date("Y-m-d");
                $menu->save();
            }
        }

        return redirect('/')->with('success', 'Matsedeln har sparats');
    }
    
    public function pdf(int $week) {

        $standard_courses = [];
        for ($i=1; $i <= 8; $i++) {
            $standard_courses[$i] = Menu::where('Vecka', $week)
                                ->where('Alternativ', $i)
                                ->where('Specialkost', 'Normal')
                                ->first();
        }

        $vegetarian_courses = [];
        for ($i=1; $i <= 8; $i++) {
            $vegetarian_courses[$i] = Menu::where('Vecka', $week)
                                ->where('Alternativ', $i)
                                ->where('Specialkost', 'Vegetarisk')
                                ->first();
        }

        $data = [
            'week' => $week,
            'standard_courses' => $standard_courses,
            'vegetarian_courses' => $vegetarian_courses,
        ];

        //return view('menu.pdf')->with($data);

        $pdf = \PDF::loadView('menu.pdf', $data);

        return $pdf->download('Matsedel vecka '.$week.'.pdf');
    }
}
