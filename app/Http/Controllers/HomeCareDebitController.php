<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Customer;
use App\Models\HomeCareOrder;

class HomeCareDebitController extends Controller
{
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    public function index(Request $request)
    {
        $months = [];
        for ($i=-6; $i <= 0; $i++) {
            $month = date("Y-m", strtotime($i." month"));
            $weeks = $this->getWeeksInMonth($month);
            $months[$month] = $month.' (vecka '.Arr::first($weeks).'-'.Arr::last($weeks).')';
        }

        $data = [
            'months' => $months,
        ];
        return view('homecaredebit.index')->with($data);
    }

    public function listajax(Request $request)
    {
        $weeks = $this->getWeeksInMonth($request->month);

        $orders = collect();
        foreach(Customer::orderBy('Namn')->get() as $customer) {
            $amount = 0;
            foreach($customer->orders->whereIn('Vecka', $weeks) as $order) {
                $amount += $order->amount();
            }
            $orders->push([
                'name' => $customer->Namn,
                'amount' => $amount
            ]);
        }

        $data = [
            'orders' => $orders,
        ];
        return view('homecaredebit.listajax')->with($data);
    }

    private function getWeeksInMonth($month) {
        $dateString = 'first thursday of '.$month;

        $startDay = new \DateTime($dateString);

        $weeks = [];
    
        while ($startDay->format('Y-m') == $month) {
            $weeks[] = intval($startDay->format('W'));
            $startDay->modify('+ 7 days');
        }
    
        return $weeks;
    }
}