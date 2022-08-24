<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantObserver
{

     /**
     * Handle the tenant "creating" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function created(Tenant $tenant)
    {
        Artisan::call("tenants:seeder", [
            'id' => $tenant->id
        ]);

    }

    /**
     * Handle the tenant "creating" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function creating(Tenant $tenant)
    {
        $tenant->uuid = Str::uuid();
        $tenant->url = Str::kebab($tenant->name);
    }

    /**
     * Handle the tenant "updating" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function updating(Tenant $tenant)
    {
        $tenant->url = Str::kebab($tenant->name);
    }
}
