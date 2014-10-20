{{ Form::open(array('route' => array($updateRoute, 'id' => $results->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
    <!-- loop fields -->
    @foreach($fields as $fieldName => $fieldProperties)
        <div class="form-group">
            {{ Form::label(ucfirst($fieldProperties['label']), ucfirst($fieldProperties['label']), array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
                {{ $renderer('edit', $className, $fieldName, $results->$fieldName) }}
            </div>
        </div>
    @endforeach

    <!-- save -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save', array('class' => 'btn btn-success')) }}
        </div>
    </div>
{{ Form::close() }}