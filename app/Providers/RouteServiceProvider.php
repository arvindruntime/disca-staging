<?php

namespace App\Providers;

use Log;
use App\Models\Board;
use App\Models\WebSitePage;
use Illuminate\Http\Request;
use App\Models\ForumBoardActivities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/user/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            try {
                $boardTopics = Board::all();
                $pages = WebSitePage::all();
                $forumTopics = ForumBoardActivities::orderBy('created_at', 'desc')->get();
                view()->share(['pages' => $pages, "boardTopics" => $boardTopics, "forumTopics" => $forumTopics]);
            } catch (Exception $e) {
                Log::error('Error in sharing data to views: ' . $e->getMessage());
            }
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            Route::prefix('api/v1')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
