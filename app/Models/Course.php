<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'Namn', 'komponent1', 'komponent2', 'komponent3', 'komponent4'
    ];

    protected $table = 'Ingredienser';

    public static function makeEmpty(): self
    {
        return self::make([
            'Namn' => 'Ingen matsedel lagd',
            'komponent1' => 'Ingenting',
            'komponent2' => 'Ingenting',
            'komponent3' => 'Ingenting',
            'komponent4' => 'Ingenting',
        ]);
    }

    public function components(): int
    {
        $k = 4;
        if($this->komponent1 == 'Ingenting') {
            $k--;
        }
        if($this->komponent2 == 'Ingenting') {
            $k--;
        }
        if($this->komponent3 == 'Ingenting') {
            $k--;
        }
        if($this->komponent4 == 'Ingenting') {
            $k--;
        }
        return $k;
    }
}
