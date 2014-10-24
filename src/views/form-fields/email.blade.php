<div class="{{ ($errors->first($fieldName)) ? 'has-error' : '' }}">
    {{ Form::email($fieldName, $fieldValue, array('class' => 'form-control')) }}
    @if($errors->first($fieldName))
        <small>{{ $errors->first($fieldName) }}</small>
    @endif
</div>