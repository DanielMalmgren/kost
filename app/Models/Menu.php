<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'Matsedel';

    public $timestamps = false;

    protected $fillable = [
        'Vecka', 'Alternativ', 'Specialkost', 'Namn', 'RegAv', 'Ingrediens_Id'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo('App\Models\Course', 'Ingrediens_Id');
    }
}

//alter table Matsedel
//Add id Int Identity(1,1)
