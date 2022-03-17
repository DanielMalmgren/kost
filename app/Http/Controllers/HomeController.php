<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HomeCareOrder;
use App\Models\OrderAO;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = session()->get('user');

        $ordered_amount = [];
        $ordered_amount_ao = [];
        for($i=0; $i < 4; $i++) { 
            $week = date("W", strtotime($i." week"));
            $ordered_amount[$week] = HomeCareOrder::where('Vecka', $week)
                ->sum(\DB::raw('Alt1 + Alt2 + Alt3 + Alt4 + Alt5 + Alt6 + Alt7 + Alt8'));
            $ordered_amount_ao[$week] = OrderAO::total_for_week($week);
        }

        $data = [
            'user' => $user,
            'ordered_amount' => $ordered_amount,
            'ordered_amount_ao' => $ordered_amount_ao,
        ];

        return view('home')->with($data);
    }

    public function logout()
    {
        session()->flush();
        return view('logout');
    }
}
