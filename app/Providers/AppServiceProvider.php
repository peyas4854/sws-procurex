<?php

namespace App\Providers;

use App\Adapters\MaatwebsiteExcelAdapter;
use App\Interfaces\ExcelExportInterface;
use Illuminate\Support\ServiceProvider;
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
        $this->app->singleton(ExcelExportInterface::class, function () {
            return new MaatwebsiteExcelAdapter;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
