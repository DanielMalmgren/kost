<?php

namespace App\Models;

class User
{
    public $name;
    public $username;
    public $title;
    public $organization;
    public $personid;
    public $isAdmin;

    public function __construct(String $username)
    {
        $aduser = \LdapRecord\Models\ActiveDirectory\User::where('sAMAccountName', $username)->first();
        $adgroup = \LdapRecord\Models\ActiveDirectory\Group::find(env('ADMIN_GROUP'));

        $this->username = $username;
        if(isset($aduser)) {
            $this->name = $aduser->displayName[0];
            $this->title = substr($aduser->title[0], 0, 22);
            $this->organization = $aduser->company[0];
            $this->personid = $aduser->employeeID[0];
            $this->isAdmin = $aduser->groups()->recursive()->exists($adgroup);
        }
    }

}
