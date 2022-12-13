<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Menu;
use App\Models\HomeCareOrder;
use PDF;

class HomeCareOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $weeks = [];
        for ($i=0; $i < 6; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'groups' => Group::orderBy('id')->get(),
        ];
        return view('homecareorder.index')->with($data);
    }

    public function create(Request $request)
    {
        $prechosen_week = date("W", strtotime("2 week"));

        $weeks = [];
        for ($i=0; $i < 12; $i++) { 
            $weeks[] = date("W", strtotime($i." week"));
        }

        $data = [
            'weeks' => $weeks,
            'prechosen_week' => $prechosen_week,
            'customers' => Customer::orderBy('Namn')->get(),
        ];
        return view('homecareorder.create')->with($data);
    }

    public function store(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        HomeCareOrder::updateOrCreate(
            [
                'Vecka' => $request->week,
                'Specialkost' => $request->specialkost,
                'Kund_id' => $customer->id,
            ],
            [
                'Kund_namn' => $customer->Namn, 
                'Kund_personnr' => $customer->Personnr, 
                'Grupp' => $customer->grupp_id, 
                'Bestdatum' => date("Y-m-d"), 
                'Bestallare' => 'ITSAM\\'.session()->get('user')->username,
                'Alt1' => $request->amount[1],
                'Alt2' => $request->amount[2],
                'Alt3' => $request->amount[3],
                'Alt4' => $request->amount[4],
                'Alt5' => $request->amount[5],
                'Alt6' => $request->amount[6],
                'Alt7' => $request->amount[7],
                'Alt8' => $request->amount[8],
            ]
        );

        return redirect('/homecareorder/create')->with('success', 'Beställningen har sparats');
    }

    public function listajax(Request $request)
    {
        $group = Group::find($request->group);

        $orders = HomeCareOrder::where('Grupp', $group->id)
                ->where('Vecka', $request->week)
                ->orderBy('Kund_namn')
                ->get();

        $ordered_amount = [];
        for($i=1; $i <= 8; $i++) { 
            $ordered_amount[$i] = HomeCareOrder::where('Vecka', $request->week)
                ->where('Grupp', $group->id)
                ->sum('Alt'.$i);
        }

        $data = [
            'orders' => $orders,
            'ordered_amount' => $ordered_amount,
            'group' => $group,
            'week' => $request->week,
        ];
        return view('homecareorder.listajax')->with($data);
    }

    public function listpdf(Request $request)
    {
        $filename = "Leveranslista vecka ".$request->week.".pdf";

        $headingaddition = '';

        $orders = collect();
        logger("Listgrupp: ".$request->listgrupp);
        foreach(Group::where('listgrupp', $request->listgrupp)->get() as $group) {
            $grouporders = $group->orders->where('Vecka', $request->week);
            if($request->spec == 'normalkost') {
                $grouporders = $grouporders->where('Specialkost', '');
                $headingaddition = ' normalkost';
            } elseif($request->spec == 'specialkost') {
                $grouporders = $grouporders->where('Specialkost', '!=', '');
                $headingaddition = ' specialkost';
            }
            $orders = $orders->merge($grouporders);
        }

        $ordered_amount = [];
        for($i=1; $i <= 8; $i++) { 
            $ordered_amount[$i] = $orders->sum('Alt'.$i);
        }

        $data = [
            'orders' => $orders->sortBy('Kund_namn'),
            'ordered_amount' => $ordered_amount,
            'listgrupp' => $request->listgrupp,
            'headingaddition' => $headingaddition,
            'week' => $request->week,
        ];
        
        //return view('homecareorder.listpdf')->with($data);

        $pdf = PDF::loadView('homecareorder.listpdf', $data);

        return $pdf->download($filename);
    }

    public function ajax(Request $request)
    {
        $customer = Customer::find($request->customer);

        if($request->type == 'Vegetarisk') {
            $menu = 'Vegetarisk';
            $vegorderchoser = 'like';
            $specialkost = 'Vegetarisk'.' '.$customer->Specialkost;
        } else {
            $menu = 'Normal';
            $vegorderchoser = 'not like';
            $specialkost = $customer->Specialkost;
        }

        $chosen_courses = [];
        for ($i=1; $i <= 8; $i++) {
            $chosen_courses[$i] = Menu::where('Vecka', $request->week)
                                ->where('Alternativ', $i)
                                ->where('Specialkost', $menu)
                                ->first();
        }

        $ordered_amount = [];
        for ($i=1; $i <= 8; $i++) {
            $amount = HomeCareOrder::where('Vecka', $request->week)
                                ->where('Kund_id', $request->customer)
                                ->where('Specialkost', $vegorderchoser, 'Vegetaris%')
                                ->first();
            if(isset($amount)) {
                $ordered_amount[$i] = $amount["Alt".$i];
            } else {
                $ordered_amount[$i] = 0;
            }
        }

        $user = session()->get('user');
        if($user->isKost) {
            $too_late = false;
            $almost_too_late = false;
        } else {
            $too_late = ($request->week < date("W", strtotime("2 week"))) && !($request->week+20 < date("W"));
            $almost_too_late = $request->week == date("W", strtotime("2 week")) && date("N") >= 4;
        }

        $data = [
            'week' => $request->week,
            'chosen_courses' => $chosen_courses,
            'ordered_amount' => $ordered_amount,
            'menu' => $menu,
            'specialkost' => $specialkost,
            'customer' => $customer,
            'too_late' => $too_late,
            'almost_too_late' => $almost_too_late,
        ];
        return view('homecareorder.ajax')->with($data);
    }
}
