<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovementType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TenantTrait;

    const ENTRADA = 'E';
    const SAIDA = 'S';
    const TRANSFERENCIA_ENTRADA = 'TE';
    const TRANSFERENCIA_SAIDA = 'TS';
    const AVALIACAO = 'AV';

    const CREATED_ENTRADA = 'Criado';
    const CREATED_SAIDA = 'Criado';
    const CREATED_TRANSFERENCIA_ENTRADA = 'Criado';
    const CREATED_TRANSFERENCIA_SAIDA = 'Criado';
    const CREATED_AVALIACAO = 'Criado';

    const COMPRA_ANIMAIS = 1;
    const ENTRADA_DOACAO_ANIMAIS = 2;
    const VENDA_ANIMAIS = 3;
    const ENTRADA_TRANSFERENCIA = 4;
    const SAIDA_TRANSFERENCIA = 5;
    const FALECIMENTO_ANIMAIS = 6;
    const PERDA_ANIMAIS = 7;
    const ROUBO_ANIMAIS = 8;
    const SAIDA_DOACAO_ANIMAIS = 9;
    const AVALIACAO_SEMANAL = 10;
    const NASCIMENTO_ANIMAIS = 11;
    const SALDO_INICIAL = 12;

    protected $fillable = [
        'name', 'operation', 'active'
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public static function isTypeEntry(string $operation)
    {
        return (self::ENTRADA == $operation || self::TRANSFERENCIA_ENTRADA == $operation);
    }

    public static function isTypeExit(string $operation)
    {
        return (self::SAIDA == $operation || self::TRANSFERENCIA_SAIDA == $operation);
    }
}
