<?php

namespace App\Providers;


use App\Livewire\CartCount as LivewireCartCount;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            $cartItemCount = (new LivewireCartCount)->countCartItems();
            $view->with('cartItemCount', $cartItemCount);

            // $wishlistCount = AddToCart::countWishlistItems();
            // $view->with('wishlistCount', $wishlistCount);
        });
    }
}
