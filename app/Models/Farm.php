<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farm extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;

    protected $appends = [
        'capatidade_maxima', 'capatidade_minima', 'hectares_uteis', 'terra_reservada', 'ocupacao_atual_maxima', 'ocupacao_atual_minima'
    ];

    protected $fillable = ['name', 'active', 'quantity_land', 'quantity_unit_land', 'legal_reservation_amount', 'top_index', 'lower_index'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function calculateIndiceMinimo()
    {
        return $this->lower_index * $this->quantity_unit_land;
    }

    public function calculateIndiceMaximo()
    {
        return $this->top_index * $this->quantity_unit_land;
    }

    public function getTerraReservadaAttribute()
    {
        return round($this->quantity_land - (($this->quantity_land * $this->legal_reservation_amount) / 100), 2);
    }

    public function getHectaresUteisAttribute()
    {
        return round($this->quantity_land * (1 - ($this->legal_reservation_amount / 100)) * $this->quantity_unit_land, 2);
    }

    public function getCapatidadeMinimaAttribute()
    {
        return round($this->getCapatidadeMinima(), 0);
    }

    public function getCapatidadeMaximaAttribute()
    {
        return round($this->getCapatidadeMaxima(), 0);
    }

    public function getOcupacaoAtualMaximaAttribute()
    {
        if($this->getCapatidadeMaxima() == 0){
            return 0;
        }
        return round(($this->animals()->count()/ $this->getCapatidadeMaxima() * 100), 2);
    }

    public function getOcupacaoAtualMinimaAttribute()
    {
        if($this->getCapatidadeMinima() == 0){
            return 0;
        }
        return round(($this->animals()->count()/ $this->getCapatidadeMinima() * 100), 2);
    }

    private function getCapatidadeMinima()
    {
        return $this->calculateIndiceMinimo() * $this->getTerraReservadaAttribute();
    }

    private function getCapatidadeMaxima()
    {
        return $this->calculateIndiceMaximo() * $this->getTerraReservadaAttribute();
    }
}
