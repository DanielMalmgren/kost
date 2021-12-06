<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAO extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'Ingredienser_AO';
}
