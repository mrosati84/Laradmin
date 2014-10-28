@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('laradmin::partials/page-header', array(
                'verb' => 'Create new',
                'className' => $className
            ))
            @include('laradmin::partials/main-action-button', array(
                'action' => 'index',
                'text' => 'Back to list',
                'glyphicon' => 'arrow-left',
                'prefix' => $prefix,
                'lowercaseClassName' => $lowercaseClassName
            ))
        </div>
    </div>

    <div class="row">
        <div ng-controller="CreateController" class="col-md-12">
            @include('laradmin::forms/create', array(
                'prefix' => $prefix,
                'lowercaseClassName' => $lowercaseClassName,
                'fields' => $fields
            ))
        </div>
    </div>
@stop