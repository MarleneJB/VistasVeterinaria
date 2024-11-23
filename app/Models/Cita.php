<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';
    protected $fillable = [
        'mascota_id',
        'servicio_id',
        'fecha_hora',
        'estado'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
