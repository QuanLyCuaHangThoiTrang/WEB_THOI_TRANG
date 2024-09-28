<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DanhMuc;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $danhmucs = DanhMuc::with('chiTietDanhMuc')->get();
        view()->share('danhmucs', $danhmucs);
    }
}
