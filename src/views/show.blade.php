@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Show {{ $className }}</h1>
            </div>
            <p>
                <a class="btn btn-success" href="{{ route($prefix . '.' . $lowercaseClassName . '.index') }}">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back to list
                </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if ($results)
                <table class="table">
                    <thead>
                        <tr>
                            @foreach($fields as $fieldName => $fieldValue)
                                <th>{{ $fieldValue['label'] }}</th>
                            @endforeach
                                <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($fields as $fieldName => $fieldValue)
                                <td>{{ $renderer('show', $className, $fieldName, $results->$fieldName) }}</td>
                            @endforeach
                                <td>
                                    @include('laradmin::actions/show', array(
                                        'prefix' => $prefix,
                                        'lowercaseClassName' => $lowercaseClassName,
                                        'results' => $results,
                                    ))
                                </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop