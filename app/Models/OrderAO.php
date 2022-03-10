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

    public function order_diets(): HasMany
    {
        return $this->hasMany('App\Models\OrderDietAO', 'Order_AO_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\DepartmentAO', 'Avdelningar_AO_id');
    }
}
