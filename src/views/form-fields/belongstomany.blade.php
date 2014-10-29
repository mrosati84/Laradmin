<div class="row {{ ($errors->first($fieldName)) ? 'has-error' : '' }}">
    <div class="col-sm-11">
        <!-- needed for empty list transmission -->
        <input type="hidden" name="{{ $fieldName }}" value="">

        {{ Form::select($fieldName . '[]',
            $relationshipModel::lists($relationshipString, 'id'),
            ($fieldValue) ? $fieldValue->lists('id') : null,
            array('multiple', 'class' => 'form-control')
        )}}
        @if($errors->first($fieldName))
            <small>{{ $errors->first($fieldName) }}</small>
        @endif
    </div>
    <div class="col-sm-1">
        <a class="btn btn-primary right-floated" href="#">
            <i class="glyphicon glyphicon-plus"></i> Add
        </a>
    </div>
</div>
