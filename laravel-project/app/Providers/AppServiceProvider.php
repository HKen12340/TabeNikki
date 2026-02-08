<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\ContentRepositoryInterface;
use App\Repositories\ContentRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ContentRepositoryInterface::class,
            ContentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    { 
        Paginator::useBootstrap();
    }
}
