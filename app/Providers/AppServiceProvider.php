<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') == 'production') {
            \URL::forceScheme('https');
        }
        
        Paginator::useBootstrap();
        Relation::morphMap([
            'resource_group' => 'App\Models\ResourceGroup',
            'user' => 'App\Models\User',
        ]);
    }
}
