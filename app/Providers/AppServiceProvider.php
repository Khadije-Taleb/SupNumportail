<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        // View Composer for Admin Layout
        view()->composer(['layouts.admin', 'admin.*'], function ($view) {
            if (auth()->check()) {
                $count = \App\Models\Notification::where('id_utilisateur', auth()->id())
                    ->where('role', 'admin')
                    ->where('is_read', false)
                    ->count();
                $view->with('unreadCount', $count);
                $view->with('unreadNotificationsCount', $count); // Keep for compatibility
            }
        });

        // View Composer for Student Layout and Views
        view()->composer(['layouts.student', 'etudiant.*'], function ($view) {
            if (auth()->check()) {
                $count = \App\Models\Notification::where('id_utilisateur', auth()->id())
                    ->where('role', 'etudiant')
                    ->where('is_read', false)
                    ->count();
                $view->with('unreadCount', $count);
            }
        });
    }
}
