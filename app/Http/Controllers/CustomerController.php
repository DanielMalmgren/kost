<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Group;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }


    public function index(Request $request)
    {
        $data = [
            'customers' => Customer::orderBy('Namn')->get(),
        ];

        return view('customer.index')->with($data);
    }

    public function create()
    {
        $data = [
            'groups' => $groups = Group::all(),
        ];

        return view('customer.create')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namn' => 'required',
            'personnr' => 'required|numeric|between:190001010000,203012319999',
        ],
        [
            'namn.required' => __('Du måste ange kundens namn!'),
            'personnr.required' => __('Du måste kundens personnummer!'),
            'personnr.numeric' => __('Du måste ange ett giltigt personnummer i rätt format!'),
            'personnr.between' => __('Du måste ange ett giltigt personnummer i rätt format!'),
        ]);

        $customer = new Customer();
        $customer->Namn = $request->namn;
        $customer->Personnr = $request->personnr;
        $customer->save();

        return $this->update($request, $customer);
    }

    public function edit(Customer $customer)
    {
        $data = [
            'customer' => $customer,
            'groups' => $groups = Group::all(),
        ];
        return view('customer.edit')->with($data);
    }

    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'namn' => 'required',
            'personnr' => 'required|numeric|between:190001010000,203012319999',
        ],
        [
            'namn.required' => __('Du måste ange kundens namn!'),
            'personnr.required' => __('Du måste kundens personnummer!'),
            'personnr.numeric' => __('Du måste ange ett giltigt personnummer i rätt format!'),
            'personnr.between' => __('Du måste ange ett giltigt personnummer i rätt format!'),
        ]);

        if($request->specialkost == 'Annat') {
            $customer->Specialkost = $request->specialkost_annan;
        } elseif ($request->specialkost == 'Normal') {
            $customer->Specialkost = "";
        } else {
            $customer->Specialkost = $request->specialkost;
        }

        $customer->Namn = $request->namn;
        $customer->Personnr = $request->personnr;
        $customer->grupp_id = $request->group;
        $customer->save();

        return redirect('/')->with('success', 'Kunden har sparats');
    }

    public function destroy(Customer $customer) {
        $customer->delete();
    }
}
