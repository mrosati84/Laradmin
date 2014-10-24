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
        <div class="col-md-12">
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
    </div>

    @include('laradmin::pagination')
@stop