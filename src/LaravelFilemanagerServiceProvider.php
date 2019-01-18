<?php

namespace Huynp\HFilemanager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelFilemanagerServiceProvider.
 */
class LaravelFilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'laravel-filemanager');

        $this->loadViewsFrom(__DIR__.'/views', 'laravel-filemanager');

        $this->publishes([
            __DIR__ . '/config/hfm.php' => base_path('config/hfm.php'),
        ], 'hfm_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/laravel-filemanager'),
        ], 'lfm_public');

        $this->publishes([
            __DIR__.'/views'  => base_path('resources/views/vendor/laravel-filemanager'),
        ], 'lfm_view');

        $this->publishes([
            __DIR__.'/Handlers/LfmConfigHandler.php' => base_path('app/Handlers/LfmConfigHandler.php'),
        ], 'lfm_handler');

        if (config('hfm.use_package_routes')) {
            Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
                \Huynp\HFilemanager\Lfm::routes();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laravel-filemanager', function () {
            return true;
        });
    }
}
