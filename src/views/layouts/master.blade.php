<!DOCTYPE html>
<html lang="en" ng-app="LaradminModule">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Config::get('laradmin::title', 'Administration') }}</title>

    <!-- stylesheets -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/base.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/layout.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/modules.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/helper-classes.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/themes.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/overrides.css') }}">
</head>
<body>

<div class="container-fluid">
    @include('laradmin::navigation')
    @yield('content')
</div>

<!-- javascripts -->
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/vendor/jquery.min.js') }}"></script>
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/vendor/jquery-ui-timepicker-addon.min.js') }}"></script>
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/vendor/angular.min.js') }}"></script>
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/vendor/bootstrap.min.js') }}"></script>

<!-- angularjs modules -->
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/modules/laradminModule.js') }}"></script>

<!-- angularjs controllers -->
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/controllers/editController.js') }}"></script>
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/controllers/createController.js') }}"></script>

<!-- main script file -->
<script src="{{ URL::asset('packages/mrosati84/laradmin/js/main.js') }}"></script>

</body>
</html>
