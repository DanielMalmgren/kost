<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialDietNeedAO extends Model
{
    use HasFactory;

    protected $table = 'Specialkostbehov_AO';

    protected $fillable = ['Antal', 'Avdelningar_AO_id'];

    public function department(): BelongsTo
    {
        return $this->belongsTo('App\Models\DepartmentAO', 'Avdelningar_AO_id');
    }
}
