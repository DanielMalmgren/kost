<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCareOrder extends Model
{
    use HasFactory;

    protected $table = 'Hemtjanst';

    public $timestamps = false;

    protected $fillable = [
        'Vecka', 'Grupp', 'Kund_namn', 'Kund_personnr', 'Specialkost', 'Bestdatum', 'Bestallare', 'Alt1', 'Alt2', 'Alt3', 'Alt4', 'Alt5', 'Alt6', 'Alt7', 'Alt8'
    ];
}

//alter table Hemtjanst
//Add id Int Identity(1,1)