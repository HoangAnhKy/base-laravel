<?php

namespace App\Providers;

use App\Models\Ideas;
use App\Models\User;
use App\Policies\IdeaPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });

        Gate::policy(Ideas::class, IdeaPolicy::class);

        $topUser = Cache::get("topUser");
        if (empty($topUser)) {
            Log::channel("cache_log")->info("Cache null \n");
            $topUser = User::withCount("idea")
                ->orderBy("idea_count", "DESC")
                ->orderBy("id", "ASC")
                ->limit(5)->get();
            Cache::set("topUser", $topUser, now()->addMinutes(10));
        } else {
            Log::channel("cache_log")->info("Cache {$topUser} \n");
        }

        View::share("topUser", $topUser);
    }
}
