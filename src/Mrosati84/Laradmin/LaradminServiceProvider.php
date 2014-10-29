<?php namespace Mrosati84\Laradmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;

class LaradminServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->package('mrosati84/laradmin');

        $prefix = Config::get('laradmin::prefix');
        $namespace = Config::get('laradmin::namespace');
        $entities = Config::get('laradmin::entities');

        foreach($entities as $entity => $properties) {
            $fullClassName = $namespace . '\\' . $entity . 'Admin';

            // register admin classes bindings
            App::bind($fullClassName, function() use ($fullClassName, $entity) {
                return new $fullClassName($entity);
            });

            // register custom filters classes
            App::bind('AuthenticationFilter', 'Mrosati84\Laradmin\RouteFilters\AuthenticationFilter');

            // register custom route filters
            Route::filter('laradmin.auth', 'AuthenticationFilter');

            // register laradmin index route (just a redirect to default entity)
            Route::get($prefix, array('as' => 'laradmin.index', function() use ($prefix) {
                return Redirect::route($prefix . '.' . strtolower(Config::get('laradmin::defaultEntity')) . '.index');
            }));

            // register entities routes
            Route::group(array('prefix' => $prefix, 'before' => 'laradmin.auth'), function() use ($entity, $fullClassName) {
                Route::resource(strtolower($entity), $fullClassName);
            });
        }
    }

    public function register()
    {
    }

    public function provides()
    {
        return array();
    }
}
