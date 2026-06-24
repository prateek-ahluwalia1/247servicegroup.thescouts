<?php

namespace App\Providers;

use App\Models\Administrator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
    // public function boot()
    // {
    //     $this->registerPolicies();

    //     //
    // }

    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            // if (session('authToken')) {
                $user = Administrator::where('auth_token', session('authToken'))->first();
                if ($user) {
                    $request->request->add(['user' => $user]);
                }
                return $user;
            // }
        });
    }
}
