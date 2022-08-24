<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collect extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;

    protected $fillable = ['name', 'amount', 'freight', 'other_values', 'arroba_price', 'movement_date', 'active'];

    public function movements()
    {
        return $this->hasMany(Movement::class)->with('animal');
    }
}
