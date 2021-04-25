<?php

namespace Dnwjn\NovaLaunch;

use Dnwjn\NovaLaunch\Http\Middleware\Authorize;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OptimistDigital\NovaTranslationsLoader\LoadsNovaTranslations;
use Symfony\Component\Finder\SplFileInfo;

class NovaLaunchServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootPublishes();
        }

        $this->bootResources();
        $this->bootRoutes();
    }

    /**
     * Bootstrap the package's publishable resources.
     *
     * @return void
     */
    protected function bootPublishes(): void
    {
        // Publish the config file.
        $this->publishes([
            __DIR__ . '/../config/nova-launch.php' => config_path('nova-launch.php'),
        ], ['config', 'minimal']);

        // Publish the migrations.
        $this->publishes($this->getMigrations(), ['migrations', 'minimal']);

        // Publish the generated files.
        $this->publishes([
            __DIR__ . '/../dist' => public_path('vendor/nova-launch'),
        ], ['public', 'minimal']);

        // Publish the translation files.
        $this->publishes([
            __DIR__ . '/../resources/lang/site' => resource_path('lang/vendor/nova-launch'),
        ], 'translations');

        // Publish the stylesheets.
        $this->publishes([
            __DIR__ . '/../resources/sass/site' => resource_path('sass/vendor/nova-launch'),
        ], 'styles');

        // Publish the views.
        $this->publishes([
            __DIR__ . '/../resources/views/site' => resource_path('views/vendor/nova-launch'),
        ], 'views');
    }

    /**
     * Retrieve the package's publishable migrations.
     *
     * @return array
     */
    protected function getMigrations(): array
    {
        $dir = __DIR__ . '/../database/migrations';
        $migrations = [];

        foreach (File::files($dir) as $file) {
            $migrations[$file->getPathname()] = $this->getMigrationName($file);
        }

        return $migrations;
    }

    /**
     * Find a migration by name or return a newly generated one.
     *
     * @param SplFileInfo $file
     * @return string
     */
    protected function getMigrationName(SplFileInfo $file): string
    {
        $timestamp = date('Y_m_d_His');
        $filename = $file->getFilename();
        $migrationsDir = database_path('migrations') . DIRECTORY_SEPARATOR;

        if ($files = File::glob("{$migrationsDir}*_{$filename}")) {
            return $files[0];
        }

        return "{$migrationsDir}{$timestamp}_{$filename}";
    }

    /**
     * Bootstrap the package's resources.
     *
     * @return void
     */
    protected function bootResources(): void
    {
        // Load Nova translations.
        $this->loadTranslations(__DIR__ . '/../resources/lang/nova', 'nova-launch');
        // Load site translations.
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/site', 'nova-launch');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-launch');
    }

    /**
     * Bootstrap the package's routes.
     *
     * @return void
     */
    protected function bootRoutes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        // Register the Nova routes.
        Route::middleware(['nova', Authorize::class])
            ->name('nova-launch.api.')
            ->namespace('Dnwjn\NovaLaunch\Http\Controllers\Api')
            ->prefix('nova-vendor/nova-launch')
            ->group(__DIR__ . '/../routes/api.php');

        // Register the visitor routes.
        Route::middleware([config('nova-launch.routes.guard', 'web')])
            ->name('nova-launch.')
            ->namespace('Dnwjn\NovaLaunch\Http\Controllers')
            ->prefix('launch')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands();
        $this->registerConfig();
    }

    /**
     * Register the package's console commands.
     */
    protected function registerCommands(): void
    {
        $this->commands([
            Console\LaunchCommand::class,
        ]);
    }

    /**
     * Merge the package's configuration with the user's configuration and register the result.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-launch.php',
            'nova-launch'
        );
    }
}
