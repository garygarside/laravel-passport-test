<?php

namespace App\Providers;

use App\Http\Resources\TransactionPaginator;
use App\Models\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->alias(TransactionPaginator::class, LengthAwarePaginator::class);
        $this->app->alias(TransactionPaginator::class, LengthAwarePaginatorContract::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Transaction::observe(TransactionObserver::class);
    }
}
