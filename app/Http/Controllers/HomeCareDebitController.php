<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\HomeCareOrder;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets\SpreadSheet;


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
            $month = date("Y-m",strtotime($i." month",strtotime(date("Y-m-01",strtotime("now")))));
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
        $this->makeOrderList($request->month, $orders, $sumLSS, $sumHemtj);

        $data = [
            'orders' => $orders,
            'sumLSS' => $sumLSS,
            'sumHemtj' => $sumHemtj,
            'month' => $request->month,
        ];
        return view('homecaredebit.listajax')->with($data);
    }

    public function gsheet(Request $request) {

        $user = session()->get('user');

        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS,
            \Google_Service_Sheets::DRIVE,
            \Google_Service_Sheets::DRIVE_FILE,
        ]);
        $client->setAccessType('offline');

        $path = storage_path(env('GOOGLE_AUTH_JSON_PATH'));
        $client->setAuthConfig($path);

        $service = new \Google_Service_Sheets($client);

        //$bold = new \Google_Service_Sheets_TextFormat();
        //$bold->setBold(true);

        //$cellFormat = new \Google_Service_Sheets_CellFormat();
        //$cellFormat->setTextFormat($bold);

        $spreadsheet = new \Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => 'Debiteringslista hemtjänst '.$request->month
            ]
        ]);
        $spreadsheet = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
        logger("Spreadsheet ID: ".$spreadsheet->spreadsheetId);

        $this->makeOrderList($request->month, $orders, $sumLSS, $sumHemtj);

        $newRow = [
            'Namn',
            'Antal portioner'
        ];
        $rows = [$newRow];
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $range = 'Sheet1';
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);

        foreach($orders as $order) {
            $newRow = [
                $order['name']." (".$order['personnr'].")",
                $order['amount']
            ];
            $rows = [$newRow];
            $valueRange = new \Google_Service_Sheets_ValueRange();
            $valueRange->setValues($rows);
            $range = 'Sheet1';
            $options = ['valueInputOption' => 'USER_ENTERED'];
            $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);
        }

        $newRow = [
            'Summa hemtjänst',
            $sumHemtj
        ];
        $rows = [$newRow];
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $range = 'Sheet1';
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);

        $newRow = [
            'Summa LSS',
            $sumLSS
        ];
        $rows = [$newRow];
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $range = 'Sheet1';
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);


        $service = new \Google_Service_Drive($client);

        $newPermission = new \Google_Service_Drive_Permission();
        $newPermission->setEmailAddress($user->email);
        $newPermission->setType('user');
        $newPermission->setRole('writer');
        //$permission = $service->permissions->create($spreadsheet->spreadsheetId, $newPermission, array('transferOwnership' => 'true', 'moveToNewOwnersRoot' => 'true'));
        $permission = $service->permissions->create($spreadsheet->spreadsheetId, $newPermission, array('moveToNewOwnersRoot' => 'true'));

        $data = [
            'id' => $spreadsheet->spreadsheetId,
        ];
        return view('homecaredebit.gsheet')->with($data);

    }

    private function makeOrderList($month, &$orders, &$sumLSS, &$sumHemtj) {
        $weeks = $this->getWeeksInMonth($month);

        $sumLSS = 0;
        $sumHemtj = 0;
        $orders = collect();
        foreach(Customer::orderBy('Namn')->get() as $customer) {
            $amount = 0;
            foreach($customer->orders->whereIn('Vecka', $weeks) as $order) {
                $amount += $order->amount();
            }
            if($customer->group->listgrupp == 'LSS') {
                $sumLSS += $amount;
            } else {
                $sumHemtj += $amount;
            }
            $orders->push([
                'name' => $customer->Namn,
                'personnr' => substr($customer->Personnr, 2, 6),
                'amount' => $amount
            ]);
        }
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
