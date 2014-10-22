<div class="{{ ($errors->first($fieldName)) ? 'has-error' : '' }}">
    {{ Form::text($fieldName, $fieldValue, array('class' => 'form-control')) }}
</div>
