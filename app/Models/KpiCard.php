<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'movement_type_id',
    ];

    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }
}
