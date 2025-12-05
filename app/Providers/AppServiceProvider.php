<?php

namespace App\Providers;

use App\Models\Tickets;
use App\Policies\TicketsPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        // Gate::define('view-reports', fn ($user) => $user->is_admin);
    }

    protected $policies = [
        Tickets::class => TicketsPolicy::class,
    ];

}
