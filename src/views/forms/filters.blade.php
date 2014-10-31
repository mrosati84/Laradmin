<div class="col-md-2">
    <h4>Filters</h4>
    {{ Form::open(array('url' => Request::url(), 'method' => 'GET')) }}
        @foreach($filtersInputs as $filterInput)
            <div class="form-group">
                {{ $filterInput['label'] }}
                {{ $filterInput['widget'] }}
            </div>
        @endforeach
        {{ Form::submit('Filter', array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
</div>
