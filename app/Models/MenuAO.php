<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAO extends Model
{
    use HasFactory;

    protected $table = 'Matsedel_AO';

    protected $fillable = ['Datum', 'Lunch1', 'Lunch2', 'Middag', 'Dessert', 'RegAv'];

    public $timestamps = false;

}
