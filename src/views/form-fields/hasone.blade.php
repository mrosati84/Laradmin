<div class="row {{ ($errors->first($fieldName)) ? 'has-error' : '' }}">
    <div class="col-sm-11">
        {{ Form::select($fieldName, $lists, $default, $attributes) }}
        @if($errors->first($fieldName))
            <small>{{ $errors->first($fieldName) }}</small>
        @endif
    </div>
    <div class="col-sm-1">
        <a class="btn btn-primary right-floated" href="#">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
    </div>
</div>
