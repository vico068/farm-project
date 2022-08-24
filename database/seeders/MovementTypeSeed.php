<?php

namespace Database\Seeders;

use App\Models\MovementType;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class MovementTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id = null)
    {
        if (!$id) return;

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'Compra de Animais';
        $movementTipe->operation = MovementType::ENTRADA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'ENTRADA - Doação de Animais';
        $movementTipe->operation = MovementType::ENTRADA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'Venda de Animais';
        $movementTipe->operation = MovementType::SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'ENTRADA - Transfêrecia entre Fazendas';
        $movementTipe->operation = MovementType::TRANSFERENCIA_ENTRADA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'SAIDA - Transfêrecia entre Fazendas';
        $movementTipe->operation = MovementType::TRANSFERENCIA_SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'Falecimento de Animais';
        $movementTipe->operation = MovementType::SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'Perda de Animais';
        $movementTipe->operation = MovementType::SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'Roubo de Animais';
        $movementTipe->operation = MovementType::SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'SAIDA - Doação de Animais';
        $movementTipe->operation = MovementType::SAIDA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'AVALIACAO - Avaliação Semanal';
        $movementTipe->operation = MovementType::AVALIACAO;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'ENTRADA - Nascimento de Animais';
        $movementTipe->operation = MovementType::ENTRADA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();

        $movementTipe =  new MovementType();
        $movementTipe->tenant_id = $id;
        $movementTipe->name = 'ENTRADA - Entrada Inicial';
        $movementTipe->operation = MovementType::ENTRADA;
        $movementTipe->allows_delete = false;
        $movementTipe->save();
    }
}
