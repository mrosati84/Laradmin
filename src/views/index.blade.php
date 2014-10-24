@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>List all {{ $className }}</h1>
            </div>
            <p>
                <a class="btn btn-success" href="{{ route($prefix . '.' . $lowercaseClassName . '.create') }}">
                    <i class="glyphicon glyphicon-plus"></i> Create new
                </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            @if ($results)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            @foreach($fields as $fieldName => $fieldValue)
                                <th>{{ $fieldValue['label'] }}</th>
                            @endforeach
                                <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                @foreach($fields as $fieldName => $fieldValue)
                                    <td>{{ $renderer('index', $className, $fieldName, $result->$fieldName) }}</td>
                                @endforeach
                                <td>
                                    @include('laradmin::actions/index', array(
                                        'prefix' => $prefix,
                                        'lowercaseClassName' => $lowercaseClassName,
                                        'result' => $result,
                                    ))
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- START: hard-coded filters, just for testing purposes -->
        <div class="col-md-2">
            <h4>Filters</h4>
            <form action="/admin/post" method="GET" role="form">
                <div class="form-group">
                    <label for="title">Title</label>
                    {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    <label for="user">Author</label>
                    <select class="form-control" name="user" id="user">
                        <option value="1">mrosati@h-art.com</option>
                        <option value="2">mfiaschini@h-art.com</option>
                        <option value="3">ndelazzari@h-art.com</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Creation date</label>
                    <input class="datetime form-control" type="text" name="created_at">
                </div>
                <div class="form-group">
                    <label for="title">Last update</label>
                    <input class="datetime form-control" type="text" name="updated_at">
                </div>
                <input type="submit" class="btn btn-default" value="Filter">
            </form>
        </div>
        <!-- END: hard-coded filters, just for testing purposes -->
    </div>

    @include('laradmin::pagination')
@stop