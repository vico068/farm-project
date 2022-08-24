<?php

namespace App\Providers;

use App\Repositories\ACL\Interfaces\PermissionRepositoryInterface;
use App\Repositories\ACL\Interfaces\ProfileRepositoryInterface;
use App\Repositories\ACL\Interfaces\RoleRepositoryInterface;
use App\Repositories\ACL\PermissionRepository;
use App\Repositories\ACL\ProfileRepository;
use App\Repositories\ACL\RoleRepository;
use App\Repositories\Interfaces\AnimalRepositoryInterface;
use App\Repositories\Interfaces\BreedRepositoryInterface;
use App\Repositories\Interfaces\FarmRepositoryInterface;
use App\Repositories\Interfaces\IronRepositoryInterface;
use App\Repositories\Interfaces\MovementRepositoryInterface;
use App\Repositories\Interfaces\MovementTypeRepositoryInterface;
use App\Repositories\IronRepository;
use App\Repositories\MovementRepository;
use App\Repositories\MovementTypeRepository;
use App\Repositories\AnimalRepository;
use App\Repositories\BreedRepository;
use App\Repositories\CollectRepository;
use App\Repositories\DetailPlanRepository;
use App\Repositories\FarmRepository;
use App\Repositories\Interfaces\CollectRepositoryInterface;
use App\Repositories\Interfaces\DetailPlanRepositoryInterface;
use App\Repositories\Interfaces\KpiCardRepositoryInterface;
use App\Repositories\Interfaces\PermissionProfileRepositoryInterface;
use App\Repositories\Interfaces\PlanProfileRepositoryInterface;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\KpiCardRepository;
use App\Repositories\PermissionProfileRepository;
use App\Repositories\PlanProfileRepository;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FarmRepositoryInterface::class, FarmRepository::class);
        $this->app->bind(BreedRepositoryInterface::class, BreedRepository::class);
        $this->app->bind(IronRepositoryInterface::class, IronRepository::class);
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
        $this->app->bind(MovementRepositoryInterface::class, MovementRepository::class);
        $this->app->bind(MovementTypeRepositoryInterface::class, MovementTypeRepository::class);

        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(DetailPlanRepositoryInterface::class, DetailPlanRepository::class);
        $this->app->bind(PermissionProfileRepositoryInterface::class, PermissionProfileRepository::class);
        $this->app->bind(PlanProfileRepositoryInterface::class, PlanProfileRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(KpiCardRepositoryInterface::class, KpiCardRepository::class);
        $this->app->bind(CollectRepositoryInterface::class, CollectRepository::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
