{{ Form::open(array('route' => array($prefix . '.' . $lowercaseClassName . '.destroy', $result->id), 'method' => 'DELETE', 'style' => 'display: inline;')) }}
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ route($prefix . '.' . $lowercaseClassName . '.show', array('id' => $result->id)) }}"><i class="glyphicon glyphicon-search"></i></a>
        <a class="btn btn-warning" href="{{ route($prefix . '.' . $lowercaseClassName . '.edit', array('id' => $result->id)) }}"><i class="glyphicon glyphicon-pencil"></i></a>
        {{ Form::close() }}
    <button onclick="return confirm('Are you sure?');" class="btn btn-danger" type="submit">
        <i class="glyphicon glyphicon-trash"></i>
    </button>
</div>
