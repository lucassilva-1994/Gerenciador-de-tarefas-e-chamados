<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        Gate::define('check-user', function (User $user) {
            return $user->visibility === 'Administrador' || $user->visibility === 'Gerente';
        });

        Gate::define('is_admin', function (User $user){
            return $user->visibility === 'Administrador';
        });
    }
}
