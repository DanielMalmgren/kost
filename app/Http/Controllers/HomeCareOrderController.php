<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeCareOrderController extends Controller
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
        return view('homecareorder.edit')->with($data);
    }
}
