{{ Form::open(array('route' => array($prefix . '.' . $lowercaseClassName . '.destroy', $results->id), 'method' => 'DELETE', 'style' => 'display: inline;')) }}
    <div class="btn-group">
        <a class="btn btn-success" href="{{ route($prefix . '.' . $lowercaseClassName . '.index') }}"><i class="glyphicon glyphicon-arrow-left"></i></a>
        <a class="btn btn-warning" href="{{ route($prefix . '.' . $lowercaseClassName . '.edit', array('id' => $results->id)) }}"><i class="glyphicon glyphicon-pencil"></i></a>
        {{ Form::close() }}
    <button class="btn btn-danger" type="submit">
        <i class="glyphicon glyphicon-remove"></i>
    </button>
</div>
