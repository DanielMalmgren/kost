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
        'Vecka', 'Grupp', 'Kund_namn', 'Kund_id', 'Kund_personnr', 'Specialkost', 'Bestdatum', 'Bestallare', 'Alt1', 'Alt2', 'Alt3', 'Alt4', 'Alt5', 'Alt6', 'Alt7', 'Alt8'
    ];

    public function amount()
    {
        return $this->Alt1 + $this->Alt2 + $this->Alt3 + $this->Alt4 + $this->Alt5 + $this->Alt6 + $this->Alt7 + $this->Alt8;
    }
}

//alter table Hemtjanst
//Add id Int Identity(1,1)

//Lägg till Kund_id (int)
//och populera den med följande:
//update hemtjanst
//set Kund_id = Kund.id from Kund where Kund.Personnr=hemtjanst.Kund_personnr
