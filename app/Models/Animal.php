<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;


    protected $fillable = [
        'farm_id', 'iron_id', 'breed_id', 'earring', 'nickname', 'obs', 'active', 'weight'
    ];


    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function iron()
    {
        return $this->belongsTo(Iron::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class)->where('farm_id', $this->farm_id);
    }

}
