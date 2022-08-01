<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        $this->configureRateLimiting();

        $this->routes(function () {
          /*                    default routes                 */
        Route::prefix('api')
          ->middleware('api')
          ->namespace($this->namespace)
          ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        /*         gestionnaire                 */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/gestionnaire.php'));
        /*         responsable etablissement    */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/responsableEtablissement.php'));

        /*         responsable etablissement    */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/internaute.php'));

        /*         ouvrier                      */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/ouvrier.php'));
        /*         client dechet                */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/clientDechet.php'));

        /*         responsable commerciale      */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/responsableCommerciale.php'));
        /*         responsable personnels       */
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/responsablePersonnels.php'));

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
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
