<div class="col-md-2">
    <h4>Filters</h4>
    {{ Form::open(array('url' => Request::url(), 'method' => 'GET')) }}
        @foreach($filtersInputs as $filterInput)
            <div class="form-group">
                {{ $filterInput['label'] }}
                {{ $filterInput['widget'] }}
            </div>
        @endforeach
        <div class="form-group">
            <div class="btn-group">
                {{ Form::submit('Filter', array('class' => 'btn btn-primary')) }}
                <a href="{{ Request::url() }}" class="btn btn-default">Reset</a>
            </div>
        </div>
    {{ Form::close() }}
</div>
