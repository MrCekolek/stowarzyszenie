<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\TileContent;
use App\Models\User;
use App\Observers\RoleObserver;
use App\Observers\TileContentObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        TileContent::observe(TileContentObserver::class);
    }
}
