<div class="row">
    <div class="col-sm-11">
        {{ Form::select($fieldName . '[]',
            $relationshipModel::lists($relationshipString, 'id'),
            ($fieldValue) ? $fieldValue->lists('id') : null,
            array('multiple', 'class' => 'form-control')
        )}}
        <input type="hidden" name="{{ $fieldName }}[]" value="0">
    </div>
    <div class="col-sm-1">
        <a class="btn btn-primary right-floated" href="#">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
    </div>
</div>
