{{ Form::open(array(
    'method' => 'POST',
    'route' => $formRoute,
    'class' => 'form-horizontal')) }}
    <!-- loop fields -->
    @foreach($fields as $fieldName => $fieldProperties)
        <div class="form-group">
            {{ Form::label(ucfirst($fieldProperties['label']),
                ucfirst($fieldProperties['label']),
                array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
                {{ $renderer('create', $className, $fieldName) }}
            </div>
        </div>
    @endforeach

    <!-- save -->
    @include('laradmin::partials/form-save')
{{ Form::close() }}