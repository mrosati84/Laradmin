<?php

namespace Mrosati84\Laradmin\RouteFilters;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class AuthenticationFilter {
    public function filter()
    {
        $authCallable = Config::get('laradmin::authCallable');
        $authRedirectRoute = Config::get('laradmin::authRedirectRoute');

        if (!$authCallable()) {
            return Redirect::route($authRedirectRoute);
        }
    }
}
