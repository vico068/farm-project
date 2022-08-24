<?php

namespace App\Providers;

use App\Services\ACL\PermissionService;
use App\Services\ACL\RoleService;
use App\Services\Interfaces\AnimalServiceInterface;
use App\Services\Interfaces\BreedServiceInterface;
use App\Services\Interfaces\FarmServiceInterface;
use App\Services\Interfaces\IronServiceInterface;
use App\Services\Interfaces\MovementServiceInterface;
use App\Services\Interfaces\MovementTypeServiceInterface;
use App\Services\IronService;
use App\Services\MovementService;
use App\Services\MovementTypeService;
use App\Services\AnimalService;
use App\Services\BreedService;
use App\Services\FarmService;
use App\Services\ACL\Interfaces\PermissionServiceInterface;
use App\Services\ACL\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\TableServiceInterface;
use App\Services\Interfaces\TenantServiceInterface;
use App\Services\TableService;
use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FarmServiceInterface::class, FarmService::class);
        $this->app->bind(BreedServiceInterface::class, BreedService::class);
        $this->app->bind(IronServiceInterface::class, IronService::class);
        $this->app->bind(AnimalServiceInterface::class, AnimalService::class);
        $this->app->bind(MovementServiceInterface::class, MovementService::class);
        $this->app->bind(MovementTypeServiceInterface::class, MovementTypeService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(TenantServiceInterface::class, TenantService::class);
        $this->app->bind(TableServiceInterface::class, TableService::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
