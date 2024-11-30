<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

use App\Models\Post;
use App\Policies\PostPolicy;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (App::environment(['production'])) {
        //     URL::forceScheme('https');
        // }
        //postのページネーション
        Paginator::useBootstrap();
    }

    protected $policies = [
        Post::class => PostPolicy::class,
    ];
}
