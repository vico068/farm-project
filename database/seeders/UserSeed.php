<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $tenant = Tenant::first();

        $tenant->users()->create([
            'name' => 'Admin',
            'email' => 'admin@wshare.com.br',
            'password' => '$2y$10$GjAekFkuWYWR7HbScaV33OhvPi.wqmV05UsMWd2EqtySUtU6TyqVG',
        ]);
    }
}
