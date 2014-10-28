Laradmin
========

Ad administration package for the [Laravel](http://www.laravel.com) framework.

Installation
------------

To use Laradmin in your Laravel project, you first have to include it in your
composer.json dependencies. Refer to [https://packagist.org/packages/mrosati84/laradmin](https://packagist.org/packages/mrosati84/laradmin)
to get the right version of the package (since it is under active development,
I suggest you to always use the `dev-develop` branch).

Your Composer `"require"` section should look like this on an empty Laravel
installation:

```json
"require": {
    "laravel/framework": "4.2.*",
    "mrosati84/laradmin": "dev-develop"
}
```

next step is to run Composer update:

    $ php /path/to/composer.phar update

you can now install package assets, it's required by Laradmin to render pages
correctly (Laradmin uses [Twitter Bootstrap](http://getbootstrap.com)) for the
frontend, and some javascript libraries as [jQuery](http://jquery.com) and
[AngularJS](https://angularjs.org):

    $ php artisan asset:publish mrosati84/laradmin

you should publish package configuration as well:

    $ php artisan config:publish mrosati84/laradmin

optionally you can also publish package views, if you need to customize the
frontend:

    $ php artisan view:publish mrosati84/laradmin

Configuring Laradmin
--------------------

All the configuration is handled by the package configuration file that you
have just published under `config/packages/mrosati84/laradmin/config.php`. You can watch an [example configuration file](https://github.com/mrosati84/Laradmin/blob/develop/src/config/config.php) is provided with the package itself.

### Laradmin configuration options

| Name | Type | Description | Default value |
|:---- |:-----|:------------|:--------------|
| `namespace` | string | the namespace for your admin classes. Rember to add it to your `composer.json` project file | *empty* |
| `prefix` | string | the route prefix for the administrator | admin |
| `title` | string | used in the HTML `<title>`. This is also used inside the Laradmin navigation top menu | Administration |
| `defaultEntity` | string | the default entity handled by Laradmin. You will be redirected to this entity if you try to navigate the prefix URL without specifying an entity name | *empty* |
| `authCallable` | string | an authentication callable that must return either `true` or `false` to determine if you can access the administration backend | `function() {}` |
| `authRedirectRoute` | string | redirect to this route name if the authentication callable returns `false` | login |
| `paginate` | string | set the default pagination. default is 10 results per page (this value is common for all entities) | 10 |
| `entities` | array | list of entities handled by Laradmin | `array()` |
