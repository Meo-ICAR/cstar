<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         * // Gate per Laravel Pulse
         * Gate::define('viewPulse', function (User $user) {
         *     return $user->email === 'hassisto@gmail.com';  // Sostituisci con la tua mail
         * });
         *
         * // Gate per Laravel Horizon
         * Gate::define('viewHorizon', function (User $user) {
         *     return $user->email === 'hassisto@gmail.com';
         * });
         */

        // Ritorna sempre true per testare se il 403 scompare
        Gate::define('viewPulse', fn ($user) => true);
        Gate::define('viewHorizon', fn ($user) => true);
    }
}
