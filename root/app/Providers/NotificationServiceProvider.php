<?php

namespace App\Providers;

use View, Session;
use Illuminate\Support\ServiceProvider;
use App\LicenseNotification;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /** get user related notifications */
        View::composer('*', function($view)
        {
            $user_id = Session::get('user_id');  
            if(Session::get('role') == 1)  {    //for admin
                $user_id = 0; // grab all the notifications where sent_to is 0
            }
            $view->with('notifications',LicenseNotification::where('sent_to', $user_id)->orderBy('sent_on', 'desc')->get());
        });

        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
