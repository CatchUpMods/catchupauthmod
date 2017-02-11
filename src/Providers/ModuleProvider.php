<?php namespace WebEd\Base\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-auth');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-auth');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-auth',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-auth'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
        ], 'webed-assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'auth.defaults' => [
                'guard' => 'web-admin',
                'passwords' => 'admin-users',
            ],
            'auth.guards.web-admin' => [
                'driver' => 'session',
                'provider' => 'admin-users',
            ],
            'auth.providers.admin-users' => [
                'driver' => 'eloquent',
                'model' => \WebEd\Base\Users\Models\User::class,
            ],
            'auth.passwords.admin-users' => [
                'provider' => 'admin-users',
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ]);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
    }
}
