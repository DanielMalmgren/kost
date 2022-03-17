<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderAO extends Model
{
    use HasFactory;

    protected $table = 'Order_AO';

    public $timestamps = false;

    protected $fillable = ['Datum', 'Avdelningar_AO_id', 'Lunch1', 'Lunch2', 'Middag', 'Dessert', 'RegAv', 'RegDatum'];

    public static function total_for_week($week): int
    {
        $current_week = date("W");
        if($week >= $current_week) {
            $year = date("Y");
        } else {
            $year = date("Y")+1;
        }

        $monday=new \DateTime();
        $monday->setISODate($year, $week, 1);
        $sunday=new \DateTime();
        $sunday->setISODate($year, $week, 7);

        $result = \DB::select("SELECT sum(Lunch1+Lunch2+Middag+Dessert) FROM Order_AO where RegDatum>=? and RegDatum<=?", [$monday->format('Y-m-d'), $sunday->format('Y-m-d')]);
        $normal = $result[0]->computed;
        if(!isset($normal)) {$normal=0;}

        $result = \DB::select("SELECT sum(Order_diets_AO.Lunch1+Order_diets_AO.Lunch2+Order_diets_AO.Middag+Order_diets_AO.Dessert) FROM Order_AO, Order_diets_AO where Order_AO.RegDatum>=? and Order_AO.RegDatum<=? and Order_diets_AO.Order_AO_id = Order_AO.id", [$monday->format('Y-m-d'), $sunday->format('Y-m-d')]);
        $diet = $result[0]->computed;
        if(!isset($diet)) {$diet=0;}

        return $normal+$diet;
    }

    public function order_diets(): HasMany
    {
        return $this->hasMany('App\Models\OrderDietAO', 'Order_AO_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\DepartmentAO', 'Avdelningar_AO_id');
    }
}
