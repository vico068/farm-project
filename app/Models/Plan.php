<?php

namespace App\Models;

use App\Tenant\Scopes\PlanScope;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'url', 'price', 'description', 'active', 'admin'];


    public function details()
    {
        return $this->hasMany(DetailPlan::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }


    public function search($filter = null)
    {
        $results = $this->where('name', 'LIKE', "%{$filter}%")
                        ->orWhere('description', 'LIKE', "%{$filter}%")
                        ->get();

        return $results;
    }

    /**
     * Profiles not linked with this plan
     */
    public function profilesAvailable($filter = null)
    {
        $profiles = Profile::whereNotIn('profiles.id', function($query) {
            $query->select('plan_profile.profile_id');
            $query->from('plan_profile');
            $query->whereRaw("plan_profile.plan_id={$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if ($filter)
                $queryFilter->where('profiles.name', 'LIKE', "%{$filter}%");
        })
        ->get();

        return $profiles;
    }

        /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // static::observe(TenantObserver::class);

        static::addGlobalScope(new PlanScope);
    }
}
