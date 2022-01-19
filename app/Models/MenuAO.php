<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuAO extends Model
{
    use HasFactory;

    protected $table = 'Matsedel_AO';

    protected $fillable = ['Datum', 'Lunch1', 'Lunch2', 'Middag', 'Dessert', 'RegAv'];

    public $timestamps = false;

    public function Lunch1_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Lunch1');
    }

    public function Lunch2_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Lunch2');
    }

    public function Middag_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Middag');
    }

    public function Dessert_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Dessert');
    }

}
