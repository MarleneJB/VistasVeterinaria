<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
