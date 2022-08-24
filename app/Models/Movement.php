<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;

    protected $fillable = [
        'farm_id', 'animal_id', 'collect_id', 'movement_type_id', 'movement_date', 'movement_name', 'weight', 'price', 'note', 'is_animal', 'operation', 'movement_date', 'active', "origin_farm_id"
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class)->with(['breed', 'iron'])->withTrashed();
    }

    public function collect()
    {
        return $this->belongsTo(Collect::class);
    }

    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
