<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        // 1. Força o Carbon (Datas) a falar Português do Brasil
        Carbon::setLocale('pt_BR');

        // 2. Avisa ao Laravel que o Front-end usa Bootstrap (para a paginação não quebrar)
        Paginator::useBootstrapFive();

        // 3. Trava de Segurança: Proíbe "Lazy Loading" (N+1) apenas no seu PC local. 
        // Se esquecer o with() no Controller, ele avisa! 
        Model::preventLazyLoading(!app()->isProduction());
    }
}