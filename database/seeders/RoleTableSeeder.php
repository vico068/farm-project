<?php

namespace Database\Seeders;

use App\Models\{
    Permission,
    Plan,
    Role,
    Tenant
};
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Users'];

        foreach($roles as $role){
            Role::create([
                'name' => $role,
                'description' => $role,
            ]);
        }

    }
}
