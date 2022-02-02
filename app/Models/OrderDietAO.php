<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDietAO extends Model
{
    use HasFactory;

    protected $table = 'Order_diets_AO';

    public $timestamps = false;

    protected $fillable = ['Namn', 'Order_AO_id', 'Lunch1', 'Lunch2', 'Middag', 'Dessert'];

    public function order(): BelongsTo
    {
        return $this->belongsTo('App\Models\OrderAO', 'Order_AO_id');
    }

}
