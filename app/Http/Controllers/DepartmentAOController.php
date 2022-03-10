<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentAO;
use App\Models\SpecialDietNeedAO;

class DepartmentAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $data = [
            'departments' => DepartmentAO::orderBy('Namn')->get(),
        ];

        return view('department_ao.index')->with($data);
    }

    public function create()
    {
        $data = [
        ];

        return view('department_ao.create')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namn' => 'required',
            'boende' => 'required|numeric|between:1,200',
        ],
        [
            'namn.required' => __('Du måste ange avdelningens namn!'),
            'boende.required' => 'Du måste ange antal boende!',
            'boende.numeric' => 'Du måste ange antal boende!',
            'boende.between' => 'Du måste ange antal boende!',
        ]);

        $department = new DepartmentAO();
        $department->Namn = $request->namn;
        $department->Boende = $request->boende;
        $department->save();

        return $this->update($request, $department);
    }

    public function edit(DepartmentAO $department)
    {
        $data = [
            'department' => $department,
            'special_diet_needs' => $department->special_diet_needs,
        ];
        return view('department_ao.edit')->with($data);
    }

    public function update(Request $request, DepartmentAO $department)
    {
        $this->validate($request, [
            'namn' => 'required',
            'boende' => 'required|numeric|between:1,200',
        ],
        [
            'namn.required' => __('Du måste ange avdelningens namn!'),
            'boende.required' => 'Du måste ange antal boende!',
            'boende.numeric' => 'Du måste ange antal boende!',
            'boende.between' => 'Du måste ange antal boende!',
        ]);

        $department->Namn = $request->namn;
        $department->Boende = $request->boende;
        $department->save();

        if(isset($request->special_diet)) {
            foreach($request->special_diet as $id => $value) {
                $special_diet_need = SpeciaLDietNeedAO::find($id);
                if($value['name'] == '' || $value['amount'] == 0) {
                    $special_diet_need->delete();
                } else {
                    $special_diet_need->Specialkost = $value['name'];
                    $special_diet_need->Antal = $value['amount'];
                    $special_diet_need->save();
                }
            }
        }
        foreach($request->new_special_diet as $id => $value) {
            if($value['name'] != '' && $value['amount'] != 0) {
                $special_diet_need = new SpeciaLDietNeedAO();
                $special_diet_need->Avdelningar_AO_id = $department->id;
                $special_diet_need->Specialkost = $value['name'];
                $special_diet_need->Antal = $value['amount'];
                $special_diet_need->save();
            }
        }

        return redirect('/')->with('success', 'Avdelningen har sparats');
    }

    public function destroy(DepartmentAO $department) {
        $department->delete();
    }
}
