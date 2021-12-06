<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDietAO extends Model
{
    use HasFactory;

    protected $table = 'Specialkost_AO';

    public function special_diet_needs(): HasMany
    {
        return $this->hasMany('App\Models\SpecialDietNeedAO', 'Specialkost_AO_id');
    }
}
