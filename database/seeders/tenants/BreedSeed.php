<?php

namespace Database\Seeders\Tenants;

use App\Models\Breed;
use Illuminate\Database\Seeder;

class BreedSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id = null)
    {
        if(!$id) return;

        $breeds = [
            ['name' => 'Nelore', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Cruzado', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Aberdeen', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Red Angus', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Senepol', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Guzerá', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Gir', 'tenant_id' => $id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        Breed::insert($breeds);

    }
}
