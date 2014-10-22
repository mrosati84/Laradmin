<div class="{{ ($errors->first($fieldName)) ? 'has-error' : '' }}">
    {{ Form::textarea($fieldName, $fieldValue, array('class' => 'form-control')) }}
</div>