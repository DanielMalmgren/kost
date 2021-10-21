<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {

        $courses = Course::orderBy('Namn')->get();

        $data = [
            'courses' => $courses,
        ];
        return view('course.index')->with($data);
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'ingredients' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ett namn på din maträtt!'),
            'ingredients.required' => __('Du måste ange ingredienser för din maträtt!'),
        ]);

        $course = new Course();
        $course->save();

        return $this->update($request, $course);
    }

    public function edit(Course $course)
    {
        $data = [
            'course' => $course,
        ];
        return view('course.edit')->with($data);
    }

    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'name' => 'required',
            'ingredients' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ett namn på din maträtt!'),
            'ingredients.required' => __('Du måste ange ingredienser för din maträtt!'),
        ]);

        $course->Namn = $request->name;
        $course->Ingredienser = $request->ingredients;
        $course->Specialkost = $request->vego?'Vegetarisk':'Normal';
        $course->RegDatum = date("Y-m-d");
        $course->RegAv = 'ITSAM\\'.session()->get('user')->username;
        $course->save();

        return redirect('/')->with('success', 'Maträtten har sparats');
    }

    public function destroy(Course $course) {
        $course->delete();
    }
}
