<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'historial';
    protected $fillable = [
        'mascota_id',
        'diagnostico',
        'tratamientos',
        'medicamentos',

    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

}
