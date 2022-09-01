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
        $orders = OrderAO::where('Avdelningar_AO_id', $this->id)->whereYear('Datum', $year)->whereMonth('Datum', $month);
        return $orders->sum('Lunch1')+$orders->sum('Lunch2');
    }

    public function dinners($year, $month)
    {

        return OrderAO::where('Avdelningar_AO_id', $this->id)->whereYear('Datum', $year)->whereMonth('Datum', $month)->sum('Middag');
    }

    public function meals($year, $month)
    {
        return $this->lunches($year, $month)+$this->dinners($year, $month);
    }
}
