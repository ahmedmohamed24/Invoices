<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class NotificationsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts/main-header', function ($view) {
            $notifications = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->orderBy('created_at', 'DESC')->take(6)->get();
            $view->with('notifications', $notifications);
        });
    }
}
