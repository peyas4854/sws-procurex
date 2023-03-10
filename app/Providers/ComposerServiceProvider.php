<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
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
        View::composer(
            ['layouts.master','employees.view'],
            'App\Http\View\Composers\MasterComposer'
        );
        // View::composer(
        //     'profile',
        //     'App\Http\View\Composers\ProfileComposer'
        // );
    }
}
