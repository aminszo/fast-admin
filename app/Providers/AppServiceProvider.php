<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

    /*
     * [amin] all codes here (in boot function) will execute in laravel startup.
     */
    public function boot()
    {

        /* [amin]
         * I changed defaultStringLength in laravel to avoid bellow error in database migration in mysql :
         * error : "Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes (SQL: alter table users add unique users_email_unique(email))"
         * if with removing this line, you don't get this error, you can feel free to delete it.
         */
        Schema::defaultStringLength(191);
    }
}
