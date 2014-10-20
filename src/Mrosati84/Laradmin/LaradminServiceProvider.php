<?php namespace Mrosati84\Laradmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class LaradminServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->package('mrosati84/laradmin');
    }

    public function register()
    {
        $prefix = Config::get('laradmin.prefix');
        $namespace = Config::get('laradmin.namespace');
        $entities = Config::get('laradmin.entities');

        foreach($entities as $entity => $properties) {
            $fullClassName = $namespace . '\\' . $entity . 'Admin';
            $baseAdminController = 'Mrosati84\Laradmin\BaseAdminController';

            // register admin classes bindings
            App::bind($fullClassName, function() use ($fullClassName, $entity) {
                return new $fullClassName($entity);
            });

            // register entities routes
            Route::group(array('prefix' => $prefix), function() use ($entity, $fullClassName) {
                Route::resource(strtolower($entity), $fullClassName);
            });
        }
    }

    public function provides()
    {
        return array();
    }
}
