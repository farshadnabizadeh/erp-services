<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\Repositories\UserModuleRepositoryInterface::class,
            \App\Repositories\UserModuleRepository::class
        );

        $this->app->bind(
            \App\Contracts\Services\MenuBuilderServiceInterface::class,
            \App\Services\MenuBuilderService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
