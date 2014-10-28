@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('laradmin::partials/page-header', array(
                'verb' => 'Show',
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

    @if ($results)
        @foreach($fields as $fieldName => $fieldValue)
            <div class="row">
                <div class="col-md-12">
                    <p><strong>{{ $fieldValue['label'] }}</strong></p>
                    <p>{{ $renderer('show', $className, $fieldName, $results->$fieldName) }}</p>
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-12">
                @include('laradmin::actions/show', array(
                    'prefix' => $prefix,
                    'lowercaseClassName' => $lowercaseClassName,
                    'results' => $results,
                ))
            </div>
        </div>
    @endif
@stop