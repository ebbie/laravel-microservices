<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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

        Passport::routes();
        Log::info("inside boot method AuthServiceProvider ");


        Gate::define('view', function(User $user, $model) {
            // return $user->hasAccess("view_".$model);
            Log::info("inside view Gate define function ".$model);
            // return $user->hasAccess("view_".$model);
            return $user->permissions()->contains("view_".$model);
            // if($user->hasAccess("view_".$model) == 1){
            //     return true;
            // } else {
            //     return false;
            // }
            // return false;
        });

        Gate::define('edit', function(User $user, $model){
            Log::info("inside edit Gate define function ".$model);
            return $user->permissions()->contains("edit_".$model);
            // return $user->hasAccess("edit_".$model);
        });
    }
}
