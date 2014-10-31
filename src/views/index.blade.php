@extends('laradmin::layouts/master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('laradmin::partials/page-header', array(
                'verb' => 'List all',
                'className' => $className
            ))
            @include('laradmin::partials/main-action-button', array(
                'action' => 'create',
                'text' => 'Create new',
                'glyphicon' => 'plus',
                'prefix' => $prefix,
                'lowercaseClassName' => $lowercaseClassName
            ))
        </div>
    </div>

    <div class="row">
        <div class="{{ ($filtersForm) ? 'col-md-10' : 'col-md-12' }}">
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

        <!-- START: filters -->
        {{ $filtersForm }}
        <!-- END: filters -->
    </div>

    @include('laradmin::pagination')
@stop