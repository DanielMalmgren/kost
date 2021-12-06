<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentAO;
use App\Models\SpecialDietAO;
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
            'special_diets' => SpecialDietAO::all(),
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
            'special_diets' => SpecialDietAO::orderBy('Namn')->get(),
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

        foreach($request->special_diets as $key => $value) {
            if($value==0) {  //TODO: FUNKAR INTE!
                $need = $department->special_diet_needs->where('Specialkost_AO_id', $key)->first();
                if($need != null) {
                    $need->delete();
                }
            } else {
                SpeciaLDietNeedAO::updateOrCreate(
                    [
                        'Avdelningar_AO_id' => $department->id,
                        'Specialkost_AO_id' => $key,
                    ],
                    [
                        'Antal' => $value,
                    ]
                );
            }
        }

        return redirect('/')->with('success', 'Avdelningen har sparats');
    }

    public function destroy(DepartmentAO $department) {
        $department->delete();
    }
}
