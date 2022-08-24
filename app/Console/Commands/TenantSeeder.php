<?php
namespace App\Console\Commands;

use App\Models\Tenant;
use Database\Seeders\MovementTypeSeed;
use Database\Seeders\Tenants\BreedSeed;
use Illuminate\Console\Command;

class TenantSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seeder {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Tenants Seeders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($id = $this->argument('id')) {
            $tenant = Tenant::find($id);
            if ($tenant) {
                $this->execCommand($tenant);
            }
        }

        return;
    }


    public function execCommand(Tenant $tenant)
    {
        $seeders = [MovementTypeSeed::class, BreedSeed::class];
        foreach ($seeders as $value) {
            $seeder = new $value;
            $seeder->callWith($value, [$tenant->id]);
        }
        return 0;
    }
}
