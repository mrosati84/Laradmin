@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('laradmin::partials/page-header', array(
                'verb' => 'Edit',
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