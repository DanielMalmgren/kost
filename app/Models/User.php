<?php

namespace App\Models;

class User
{
    public $name;
    public $username;
    public $title;
    public $organization;
    public $personid;
    public $isKost;
    public $isHemtj;

    public function __construct(String $username)
    {
        $aduser = \LdapRecord\Models\ActiveDirectory\User::where('sAMAccountName', $username)->first();
        $kostgroup = \LdapRecord\Models\ActiveDirectory\Group::find(env('KOST_GROUP'));
        $hemtjgroup = \LdapRecord\Models\ActiveDirectory\Group::find(env('HEMTJ_GROUP'));
        $itsgroup = \LdapRecord\Models\ActiveDirectory\Group::find(env('ITS_GROUP'));

        $this->username = $username;
        if(isset($aduser)) {
            $this->name = $aduser->displayName[0];
            $this->title = substr($aduser->title[0], 0, 22);
            $this->organization = $aduser->company[0];
            $this->personid = $aduser->employeeID[0];
            $this->isKost = $aduser->groups()->recursive()->exists($kostgroup)||$aduser->groups()->recursive()->exists($itsgroup);
            $this->isHemtj = $aduser->groups()->recursive()->exists($hemtjgroup)||$aduser->groups()->recursive()->exists($itsgroup);
        }
    }

}
