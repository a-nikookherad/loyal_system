<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //passport routes
        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }

        //passport token expiration time
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        $rolesCollection = Role::query()
            ->get();

        foreach ($rolesCollection as $role) {
            Gate::define($role->name, function (User $user) use ($role, $rolesCollection) {
                return $user->hasRole($role->name, $rolesCollection);
            });
        }
    }
}
