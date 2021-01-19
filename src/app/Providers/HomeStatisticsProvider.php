<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\ServiceProvider;

class HomeStatisticsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       view()->composer('home/index',function($view){
           $data['inovices_count']=Invoice::count();
           $data['inovices_not']=Invoice::where('status',0)->count();
           $data['inovices_paid']=Invoice::where('status',1)->count();
           $data['inovices_part']=Invoice::where('status',2)->count();
           $data['users']=User::role('user')->count();
           $data['admins']=User::role('admin')->count();
           $data['super_admins']=User::role('super admin')->count();
           $data['owners']=User::role('owner')->count();
           $data['noRoles']= User::doesntHave('roles')->count();
           $view->with('data',$data);
       });
    }
}
