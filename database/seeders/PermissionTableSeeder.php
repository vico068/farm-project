<?php

namespace Database\Seeders;

use App\Models\{
    Permission,
    Plan,
    Tenant
};
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = ['farms', 'users', 'breads', 'irons', 'movements', 'roles', 'kpi_cards', 'permissions', 'plans', 'tenants', 'profiles'];
        $permisionLabels = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

        foreach ($tables as $table) {
            foreach ($permisionLabels as $permisionLabel) {
                Permission::create([
                    'name' => $permisionLabel . '_' . $table,
                    'description' => $permisionLabel . '_' . $table,
                ]);
            }
        }

    }
}
