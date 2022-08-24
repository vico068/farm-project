<?php

namespace App\Providers;

use App\Models\Farm;
use App\Models\Plan;
use App\Models\Table;
use App\Models\Tenant;
use App\Observers\PlanObserver;
use App\Observers\TableObserver;
use App\Observers\TenantObserver;
use App\Repositories\FarmRepository;
use App\Services\FarmService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Plan::observe(PlanObserver::class);
        Tenant::observe(TenantObserver::class);
        Table::observe(TableObserver::class);

    }
}
