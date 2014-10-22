@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Edit {{ $className }}</h1>
            </div>
            <p>
                <a class="btn btn-success" href="{{ route($prefix . '.' . $lowercaseClassName . '.index') }}">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back to list
                </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div ng-controller="EditController" class="col-md-12">
            @include('laradmin::forms/edit', array(
                'results' => $results,
                'prefix' => $prefix,
                'lowercaseClassName' => $lowercaseClassName,
                'fields' => $fields
            ))
        </div>
    </div>
@stop