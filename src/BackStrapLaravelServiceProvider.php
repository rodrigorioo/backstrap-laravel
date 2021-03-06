<?php

namespace Rodrigorioo\BackStrapLaravel;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Rodrigorioo\BackStrapLaravel\Facades\BackStrapLaravel;
use Rodrigorioo\BackStrapLaravel\Http\Middleware\AdminAuthenticate;
use Rodrigorioo\BackStrapLaravel\View\Components\Errors;

class BackStrapLaravelServiceProvider extends ServiceProvider {

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @return void
     */
    public function register() {

        // Config
        $configPath = __DIR__.'/../config/backstrap_laravel.php';
        $this->mergeConfigFrom($configPath, 'backstrap_laravel');

        // Facades
        $this->app->bind('backstrap_laravel', function($app) {
            return new BackStrapLaravelService;
        });

        // Middlewares
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('backstrap_laravel_admin_authenticate', AdminAuthenticate::class);
        $router->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class);
        $kernel = $this->app->make(Kernel::class);

        // Guards
        $this->addGuard();

        // Filesystems
        $this->addFilesystem();
    }

    public function boot () {

        // Config
        $configPath = __DIR__.'/../config/backstrap_laravel.php';
        $this->publishes([
            $configPath => config_path('backstrap_laravel.php'),
        ], 'config');

        // Assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/backstrap_laravel'),
        ], 'assets');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Seeders
        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'seeders');

        // Roles & Permissions
        $rolesEnabled = config('backstrap_laravel.crud_roles.enable');
        $permissionsEnabled = config('backstrap_laravel.crud_permissions.enable');
        if($rolesEnabled && $permissionsEnabled) {
            Gate::before(function ($user, $ability) {
                return $user->hasRole('super-admin') ? true : null;
            });
        }

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'backstrap_laravel');

        // View components
        $this->loadViewComponentsAs('backstrap_laravel', [
            Errors::class,
        ]);

        // Translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'backstrap_laravel');

        // Send template configuration
        view()->composer('backstrap_laravel::login', function($view) {
            $view->with('templateConfiguration', BackStrapLaravel::getTemplateConfiguration());
        });

        view()->composer('backstrap_laravel::forgot_password', function($view) {
            $view->with('templateConfiguration', BackStrapLaravel::getTemplateConfiguration());
        });

        view()->composer('backstrap_laravel::reset_password', function($view) {
            $view->with('templateConfiguration', BackStrapLaravel::getTemplateConfiguration());
        });

        view()->composer('backstrap_laravel::admin.layout', function($view) {
            $view->with('templateConfiguration', BackStrapLaravel::getTemplateConfiguration());
        });
    }

    /**
     * @return array
     */
    public function provides() {
        return ['BackStrapLaravel'];
    }

    public function addGuard () {

        $config = $this->app->make('config');

        $guard = config('backstrap_laravel.guard');
        $adminModel = config('backstrap_laravel.admin_model');

        $config->set('auth.guards.'.$guard['name'], [
            'driver' => $guard['driver'],
            'provider' => $guard['provider']['name'],
        ]);

        $config->set('auth.providers.'.$guard['provider']['name'], [
            'driver' => $guard['provider']['driver'],
            'model' => $adminModel,
        ]);

        $config->set('auth.passwords.'.$guard['provider']['name'], [
            'provider' => $guard['provider']['name'],
            'table' => $guard['passwords']['table'],
            'expire' => $guard['passwords']['expire'],
            'throttle' => $guard['passwords']['throttle'],
        ]);
    }

    public function addFilesystem () {

        $config = $this->app->make('config');

        $uploadFile = config('backstrap_laravel.upload_file');

        $config->set('filesystems.disks.backstrap_laravel', [
            'driver' => $uploadFile['driver'],
            'root' => public_path($uploadFile['directory']),
        ]);
    }
}
