{{ Form::open(array('route' => array($prefix . '.' . $lowercaseClassName . '.destroy', $results->id), 'method' => 'DELETE', 'style' => 'display: inline;')) }}
    <div class="btn-group">
        <a class="btn btn-warning" href="{{ route($prefix . '.' . $lowercaseClassName . '.edit', array('id' => $results->id)) }}"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
        {{ Form::close() }}
    <button onclick="return confirm('Are you sure?');" class="btn btn-danger" type="submit">
        <i class="glyphicon glyphicon-remove"></i> Destroy
    </button>
</div>
