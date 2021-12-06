<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepartmentAO extends Model
{
    use HasFactory;

    protected $table = 'Avdelningar_AO';

    public function special_diet_needs(): HasMany
    {
        return $this->hasMany('App\Models\SpecialDietNeedAO', 'Avdelningar_AO_id');
    }
}
