<?php

use App\Http\Controllers\Api\Admin\ACL\PermissionController;
use App\Http\Controllers\Api\Admin\ACL\PermissionProfileController;
use App\Http\Controllers\Api\Admin\ACL\PermissionRoleController;
use App\Http\Controllers\Api\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Api\Admin\ACL\ProfileController;
use App\Http\Controllers\Api\Admin\ACL\RoleController;
use App\Http\Controllers\Api\Admin\ACL\RoleUserController;
use App\Http\Controllers\Api\Admin\ACL\UserController;
use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\BreedController;
use App\Http\Controllers\Api\CollectController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DetailPlanController;
use App\Http\Controllers\Api\FarmController;
use App\Http\Controllers\Api\GainReportController;
use App\Http\Controllers\Api\IronController;
use App\Http\Controllers\Api\KpiCardController;
use App\Http\Controllers\Api\MapaController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\MovementTypeController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TableApiController;
use App\Http\Controllers\Api\TenantApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/tables/{identify}',  [TableApiController::class, 'show']);
Route::get('/tables', [TableApiController::class, 'tablesByTenant']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('plans', [PlanController::class, 'index']);
Route::get('plans/{url}/details', [DetailPlanController::class, 'index']);



Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/tenants/{uuid}', [TenantApiController::class, 'show']);

    Route::apiResource('farms', FarmController::class);
    Route::apiResource('irons', IronController::class);
    Route::apiResource('breeds', BreedController::class);
    Route::apiResource('animals', AnimalController::class);
    Route::apiResource('collects', CollectController::class);
    Route::apiResource('kpi-cards', KpiCardController::class);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('farms/{farm_id}/mapas', [MapaController::class, 'index']);

    Route::get('collects/{id}/movements', [CollectController::class, 'movements']);

    Route::apiResource('movements', MovementController::class);
    Route::post('movements/import', [MovementController::class, 'import']);

    Route::apiResource('movement-types', MovementTypeController::class);
    Route::post('monitoring', [MovementController::class, 'store']);
    Route::get('farms/{farm_id}/animals', [AnimalController::class, 'animalsByFarm']);
    Route::get('stocks', [StockController::class, 'index']);
    Route::post('reports/gains/farms/{farm_id}', [GainReportController::class, 'index']);

    Route::get('stocks/advanced', [StockController::class, 'advanced']);

    Route::prefix('admin')->group(function () {

        Route::get('tenants', [TenantApiController::class, 'index']);

        //Routes Users
        Route::apiResource('users', UserController::class);

        /**
         * Routes Plans
         */
        Route::any('plans/search', [PlanController::class, 'search'])->name('plans.search');
        Route::apiResource('plans', PlanController::class);

        /**
         * Routes Details Plans
         */

        Route::apiResource('plans/{url}/details', DetailPlanController::class);

        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);


        /**
         * Permission x Role
         */
        Route::delete('roles/{id}/permission/{idPermission}/detach', [PermissionRoleController::class, 'detachPermissionRole'])->name('roles.permission.detach');
        Route::post('roles/{id}/permissions', [PermissionRoleController::class, 'attachPermissionsRole'])->name('roles.permissions.attach');
        Route::get('roles/{id}/permissions/create', [PermissionRoleController::class, 'permissionsAvailable'])->name('roles.permissions.available');
        Route::get('roles/{id}/permissions', [PermissionRoleController::class, 'permissions'])->name('roles.permissions');
        Route::get('permissions/{id}/role', [PermissionRoleController::class, 'roles'])->name('permissions.roles');

        /**
         * Role x User
         */
        Route::get('users/{id}/role/{idRole}/detach', [RoleUserController::class, 'detachRoleUser'])->name('users.role.detach');
        Route::post('users/{id}/roles', [RoleUserController::class, 'attachRolesUser'])->name('users.roles.attach');
        Route::get('users/{id}/roles/create', [RoleUserController::class, 'rolesAvailable'])->name('users.roles.available');
        Route::get('users/{id}/roles', [RoleUserController::class, 'roles'])->name('users.roles');
        Route::get('roles/{id}/users', [RoleUserController::class, 'users'])->name('roles.users');

        /**
         * Routes Permissions
         */
        Route::any('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');

        /**
         * Routes Profiles
         */
        Route::any('profiles/search', [ProfileController::class, 'search'])->name('profiles.search');
        Route::resource('profiles', ProfileController::class);

        /**
         * Plan x Profile
         */
        Route::delete('plans/{id}/profile/{idProfile}/detach', [PlanProfileController::class, 'detachProfilePlan'])->name('plans.profile.detach');
        Route::post('plans/{id}/profiles',  [PlanProfileController::class, 'attachProfilesPlan'])->name('plans.profiles.attach');
        Route::any('plans/{id}/profiles/create', [PlanProfileController::class, 'profilesAvailable'])->name('plans.profiles.available');
        Route::get('plans/{id}/profiles', [PlanProfileController::class, 'profiles'])->name('plans.profiles');
        Route::get('profiles/{id}/plans', [PlanProfileController::class, 'plans'])->name('profiles.plans');

        /**
         * Permission x Profile
         */
        Route::delete('profiles/{id}/permission/{idPermission}/detach', [PermissionProfileController::class, 'detachPermissionProfile'])->name('profiles.permission.detach');
        Route::post('profiles/{id}/permissions', [PermissionProfileController::class, 'attachPermissionsProfile'])->name('profiles.permissions.attach');
        Route::any('profiles/{id}/permissions/create', [PermissionProfileController::class, 'permissionsAvailable'])->name('profiles.permissions.available');
        Route::get('profiles/{id}/permissions', [PermissionProfileController::class, 'permissions'])->name('profiles.permissions');
        Route::get('permissions/{id}/profile', [PermissionProfileController::class, 'profiles'])->name('permissions.profiles');
    });
});
