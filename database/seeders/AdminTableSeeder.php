<?php

namespace Database\Seeders;

use App\Models\{
    Plan,
    Tenant,
    DetailPlan
};
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plan = Plan::create([
            'name' => 'admin',
            'url' => 'admin',
            'price' => 9999999.99,
            'description' => 'admin',
            'admin' => true
        ]);

        $tenant = $plan->tenants()->create([
            'cnpj' => '11125339000130',
            'name' => 'WShare',
            'url' => 'wshare',
            'email' => 'admin@wshare.com.br',
        ]);


        $tenant->users()->create([
            'name' => 'Admin',
            'email' => 'admin@wshare.com.br',
            'password' => '$2y$10$GjAekFkuWYWR7HbScaV33OhvPi.wqmV05UsMWd2EqtySUtU6TyqVG',
        ]);

        $plansArray = [
            [
                'name' => 'W-Starter',
                'url' => 'wstarter',
                'price' => 199.90,
                'description' => 'Plano inicial pequenos manejos anuais',
                'details' =>  [
                    ['name' => '01 Fazenda'],
                    ['name' => '1 até 500 animais ativos'],
                    ['name' => 'APP Android e IOS'],
                    ['name' => 'Até 5 usuários'],
                    ['name' => 'Free Setup'],
                ],
            ],
            [
                'name' => 'W-Professional',
                'url' => 'wprofessional',
                'price' => 299.90,
                'description' => 'Plano intermediário manejo de gado',
                'details' =>   [
                    ['name' => '10 Fazendas'],
                    ['name' => '501 até 1.000 animais ativos'],
                    ['name' => 'APP Android e IOS'],
                    ['name' => 'Até 10 usuários'],
                    ['name' => 'Free Setup'],
                ],
            ],
            [
                'name' => 'W-Enterprise',
                'url' => 'wenterprise',
                'price' => 499.90,
                'description' => 'Plano avançado manejo de gado',
                'details' => [
                    ['name' => '25 Fazendas'],
                    ['name' => '1001 até 2.500 animais ativos'],
                    ['name' => 'APP Android e IOS'],
                    ['name' => 'Até 50 usuários'],
                    ['name' => 'Free Setup'],
                ],
            ],
            [
                'name' => 'W-Unlimited',
                'url' => 'wunlimited',
                'price' => 0.00,
                'description' => 'Plano acima de 2.500 gados ativos',
                'details' =>   [
                    ['name' => 'Fazendas sob consulta'],
                    ['name' => 'Acima de 2.500 animais ativos'],
                    ['name' => 'APP Android e IOS'],
                    ['name' => 'Qtde de usuários sob consulta'],
                    ['name' => 'Setup sob consulta'],
                ],
            ],
        ];

        foreach ($plansArray as $value) {

            $details = $value['details'];
            unset($value['details']);
            $plan = Plan::create($value);
            $plan->details()->createMany($details);

        }
    }
}
