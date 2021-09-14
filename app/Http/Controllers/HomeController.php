<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\FrejaAPI;

class HomeController extends Controller
{
    use FrejaAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authnodb');
    }

    private function getUser(Request $request)
    {
        $user = session()->get('user');
        if($user->isAdmin && $request->username !== null) {
            return new User($request->username);
        } else {
            return session()->get('user');
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $this->getUser($request);

        $data = [
            'user' => $user,
        ];

        return view('home')->with($data);
    }

    public function logout()
    {
        session()->flush();
        return view('logout');
    }

    public function orgid(Request $request)
    {
        $user = $this->getUser($request);

        $reference = $this->addOrgId($user);

        if($reference === null) {
            return view('orgid/failure');
        }

        $data = [
            'user' => $user,
            'reference' => $reference,
        ];

        return view('orgid/success')->with($data);
    }

    public function orgidResult(Request $request) {
        $user = $this->getUser($request);
        $reference = $request->reference;
        return $this->getOneResult($user, $reference);
    }
}
