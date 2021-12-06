<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAO;

class CourseAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {

        $courses = CourseAO::orderBy('namn')->get();

        $data = [
            'courses' => $courses,
        ];
        return view('course_ao.index')->with($data);
    }

    public function create()
    {
        return view('course_ao.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ett namn på din maträtt!'),
        ]);

        $course = new CourseAO();
        $course->save();

        return $this->update($request, $course);
    }

    public function edit(CourseAO $course)
    {
        $data = [
            'course' => $course,
        ];
        return view('course_ao.edit')->with($data);
    }

    public function update(Request $request, CourseAO $course)
    {
        $this->validate($request, [
            'name' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ett namn på din maträtt!'),
        ]);

        $course->Namn = $request->name;
        $course->komponent1 = $request->komp1;
        $course->komponent2 = $request->komp2;
        $course->komponent3 = $request->komp3;
        $course->komponent4 = $request->komp4;
        $course->RegDatum = date("Y-m-d");
        $course->RegAv = 'ITSAM\\'.session()->get('user')->username;
        $course->save();

        return redirect('/')->with('success', 'Maträtten har sparats');
    }

    public function destroy(CourseAO $course) {
        $course->delete();
    }
}
