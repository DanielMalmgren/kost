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
        return $this->belongsTo('App\Models\Course', 'Lunch1')->withDefault([
            'Namn' => 'Ingen matsedel lagd',
            'komponent1' => 'Ingenting',
            'komponent2' => 'Ingenting',
            'komponent3' => 'Ingenting',
            'komponent4' => 'Ingenting',
        ]);
    }

    public function Lunch2_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Lunch2')->withDefault([
            'Namn' => 'Ingen matsedel lagd',
            'komponent1' => 'Ingenting',
            'komponent2' => 'Ingenting',
            'komponent3' => 'Ingenting',
            'komponent4' => 'Ingenting',
        ]);
    }

    public function Middag_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Middag')->withDefault([
            'Namn' => 'Ingen matsedel lagd',
            'komponent1' => 'Ingenting',
            'komponent2' => 'Ingenting',
            'komponent3' => 'Ingenting',
            'komponent4' => 'Ingenting',
        ]);
    }

    public function Dessert_object(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Dessert')->withDefault([
            'Namn' => 'Ingen matsedel lagd',
            'komponent1' => 'Ingenting',
            'komponent2' => 'Ingenting',
            'komponent3' => 'Ingenting',
            'komponent4' => 'Ingenting',
        ]);
    }

}
