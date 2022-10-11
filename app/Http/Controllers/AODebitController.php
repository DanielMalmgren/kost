<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\DepartmentAO;

class AODebitController extends Controller
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
            $months[$month] = $month;
        }

        $data = [
            'months' => $months,
        ];
        return view('aodebit.index')->with($data);
    }

    public function listajax(Request $request)
    {
        $montharray = explode('-', $request->month);
        $data = [
            'departments' => DepartmentAO::orderBy('Namn')->get(),
            'year' => $montharray[0],
            'month' => $montharray[1],
        ];
        return view('aodebit.listajax')->with($data);
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

        $spreadsheet = new \Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => 'Debiteringslista äldreomsorg '.$request->year.'-'.$request->month
            ]
        ]);
        $spreadsheet = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
        logger("Spreadsheet ID: ".$spreadsheet->spreadsheetId);

        $newRow = [
            'Avdelningar',
            'Luncher',
            'Middagar',
            'Totalt'
        ];
        $rows = [$newRow];
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $range = 'Sheet1';
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);

        $departments = DepartmentAO::orderBy('Namn')->get();

        $lunches_total = 0;
        $dinners_total = 0;

        foreach($departments as $department) {

            $lunches = $department->lunches($request->year, $request->month);
            $dinners = $department->dinners($request->year, $request->month);
            $lunches_total += $lunches;
            $dinners_total += $dinners;

            $newRow = [
                $department->Namn,
                $lunches,
                $dinners,
                $lunches+$dinners
            ];
            $rows = [$newRow];
            $valueRange = new \Google_Service_Sheets_ValueRange();
            $valueRange->setValues($rows);
            $range = 'Sheet1';
            $options = ['valueInputOption' => 'USER_ENTERED'];
            $service->spreadsheets_values->append($spreadsheet->spreadsheetId, $range, $valueRange, $options);
        }

        $newRow = [
            '',
            $lunches_total,
            $dinners_total,
            $lunches_total+$dinners_total
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
        $newPermission->setRole('writer'); //owner
        //$permission = $service->permissions->create($spreadsheet->spreadsheetId, $newPermission, array('transferOwnership' => 'true', 'moveToNewOwnersRoot' => 'true'));
        $permission = $service->permissions->create($spreadsheet->spreadsheetId, $newPermission, array('moveToNewOwnersRoot' => 'true'));

        $data = [
            'id' => $spreadsheet->spreadsheetId,
        ];
        return view('homecaredebit.gsheet')->with($data);

    }
}
