<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderAO;

class DepartmentAO extends Model
{
    use HasFactory;

    protected $table = 'Avdelningar_AO';

    public function special_diet_needs(): HasMany
    {
        return $this->hasMany('App\Models\SpecialDietNeedAO', 'Avdelningar_AO_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany('App\Models\OrderAO', 'Avdelningar_AO_id');
    }

    public function lunches($year, $month)
    {
        $result = \DB::select("SELECT sum(Lunch1)+sum(Lunch2) FROM Order_AO where Avdelningar_AO_id=? and year(Datum)=? and month(Datum)=?", [$this->id, $year, $month]);
        $normal = $result[0]->computed;
        if(!isset($normal)) {$normal=0;}

        $result = \DB::select("SELECT sum(Order_diets_AO.Lunch1+Order_diets_AO.Lunch2) FROM Order_AO, Order_diets_AO where Avdelningar_AO_id=? and year(Datum)=? and month(Datum)=? and Order_diets_AO.Order_AO_id = Order_AO.id", [$this->id, $year, $month]);
        $diet = $result[0]->computed;
        if(!isset($diet)) {$diet=0;}

        return $normal+$diet;

    }

    public function dinners($year, $month)
    {
        $result = \DB::select("SELECT sum(Middag) FROM Order_AO where Avdelningar_AO_id=? and year(Datum)=? and month(Datum)=?", [$this->id, $year, $month]);
        $normal = $result[0]->computed;
        if(!isset($normal)) {$normal=0;}

        $result = \DB::select("SELECT sum(Order_diets_AO.Middag) FROM Order_AO, Order_diets_AO where Avdelningar_AO_id=? and year(Datum)=? and month(Datum)=? and Order_diets_AO.Order_AO_id = Order_AO.id", [$this->id, $year, $month]);
        $diet = $result[0]->computed;
        if(!isset($diet)) {$diet=0;}

        return $normal+$diet;
    }

    public function meals($year, $month)
    {
        return $this->lunches($year, $month)+$this->dinners($year, $month);
    }
}
