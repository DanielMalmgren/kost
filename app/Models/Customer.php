<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'Kund';

    public function group(): BelongsTo
    {
        return $this->belongsTo('App\Models\Group', 'grupp_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany('App\Models\HomeCareOrder', 'kund_id');
    }

    public function deletable(): bool
    {
        $count = DB::table('Hemtjanst')
        ->whereRaw('Kund_id=? and datediff(day, bestdatum, getdate()) < 60', [$this->id])
        ->count();
        return $count == 0;
    }
}
