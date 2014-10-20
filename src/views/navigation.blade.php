<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Administration</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            @foreach(Config::get('laradmin.entities') as $entity => $properties)
                <li class="{{ (Request::is('*'.strtolower($entity).'*')) ? 'active' : '' }}">
                    <a href="{{ route(Config::get('laradmin.prefix') . '.' . strtolower($entity) . '.index') }}">{{ ucfirst($entity) }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
