<!DOCTYPE html>
<html lang="en" ng-app="LaradminModule">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Config::get('laradmin::title', 'Administration') }}</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/vendor/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/mrosati84/laradmin/css/main.css') }}">
</head>
<body>

<div class="container">
    <div class="row">
        @include('laradmin::navigation')
        @yield('content')
    </div>
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