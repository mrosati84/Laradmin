@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Show {{ $className }}</h1>
            </div>
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