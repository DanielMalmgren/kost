<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderAOController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $data = [
        ];

        return view('order_ao.index')->with($data);
    }

}
