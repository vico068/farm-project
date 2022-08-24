<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iron extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;

    protected $fillable = ['name'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

}
