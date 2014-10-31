<?php

namespace Mrosati84\Laradmin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;

class BaseAdminController extends Controller
{
    const DEFAULT_PAGINATION  = 10;

    /**
     * @return Response
     */
    public function index()
    {
        $className = $this->getClassName();

        Input::flash();

        // filter results
        $filters = $this->getFilters();
        $queryFilter = new QueryFilter($filters);
        $filtersForm = $queryFilter->getFiltersForm();
        $results = $className::paginate(Config::get('laradmin::paginate', self::DEFAULT_PAGINATION));
        $filteredResults = $queryFilter->filter($results);

        return View::make('laradmin::index', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFieldRenderer(),
            'filtersForm' => $filtersForm,

            'results' => $filteredResults
        ));
    }

    /**
     * @return Response
     */
    public function create()
    {
        $className = $this->getClassName();

        return View::make('laradmin::create', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFormFieldRenderer(),
            'formRoute' => $this->getRouteNameForEntity('store')
        ));
    }

    /**
     * @return Response
     */
    public function store()
    {
        $className = $this->getClassName();
        $fields = $this->getFields();

        // create new entity
        $newRecord = new $className;

        // validate entity
        $validator = $this->getValidator();

        if ($validator->fails()) {
            return Redirect::route($this->getRouteNameForEntity('create'))
                ->with(array(
                    'calloutTitle' => 'Validation errors',
                    'calloutMessage' => 'There are validation errors that must
                        be fixed. Please check your input data before
                        submitting the form again.',
                    'calloutClass' => 'warning',
                ))
                ->withInput()
                ->withErrors($validator);
        }

        // save regular columns
        foreach($fields as $fieldName => $fieldProperties) {
            switch ($fieldProperties['type'] ) {
                case 'string':
                case 'number':
                case 'textarea':
                case 'email':
                case 'password':
                case 'datetime':
                    $processedInput = $this->preprocessInputField($fieldName, Input::get($fieldName));
                    $newRecord->$fieldName = $processedInput;

                    break;
            }
        }

        // persist record
        try {
            if ($newRecord->save()) {
                $this->saveRelatedModels($newRecord);
                return Redirect::route($this->getRouteNameForEntity());
            }
        } catch(QueryException $e) {
            return Redirect::route($this->getRouteNameForEntity('create'))
                ->with(array(
                    'calloutTitle' => 'Error running query',
                    'calloutMessage' => $this->getPreformattedText($e->getMessage()),
                    'calloutClass' => 'danger',
                ));
        }
    }

    /**
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $className = $this->getClassName();
        $results = $className::find($id);

        return View::make('laradmin::show', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFieldRenderer(),

            'results' => $results
        ));
    }

    /**
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $className = $this->getClassName();
        $results = $className::find($id);

        return View::make('laradmin::edit', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFormFieldRenderer(),
            'formRoute' => $this->getRouteNameForEntity('update'),

            'results' => $results
        ));
    }

    /**
     * @param $id
     * @return Response
     */
    public function update($id)
    {
        $className = $this->getClassName();
        $fields = $this->getFields();

        $record = $className::find($id);

        // validate entity
        $validator = $this->getValidator();

        if ($validator->fails()) {
            return Redirect::route($this->getRouteNameForEntity('edit'), array('id' => $id))
                ->with(array(
                    'calloutTitle' => 'Validation errors',
                    'calloutMessage' => 'There are validation errors that must
                        be fixed. Please check your input data before
                        submitting the form again.',
                    'calloutClass' => 'warning',
                ))
                ->withInput()
                ->withErrors($validator);
        }

        // save regular columns
        foreach($fields as $fieldName => $fieldProperties) {
            switch ($fieldProperties['type'] ) {
                case 'string':
                case 'number':
                case 'textarea':
                case 'email':
                case 'password':
                case 'datetime':
                    $processedInput = $this->preprocessInputField($fieldName, Input::get($fieldName));

                    if ($record->$fieldName != $processedInput) {
                        $record->$fieldName = $processedInput;
                    }

                    break;
            }
        }

        try {
            if ($record->save()) {
                $this->saveRelatedModels($record);
                return Redirect::route($this->getRouteNameForEntity());
            }
        } catch(QueryException $e) {
            return Redirect::route($this->getRouteNameForEntity('edit'), array('id' => $id))
                ->with(array(
                    'calloutTitle' => 'Error running query',
                    'calloutMessage' => $this->getPreformattedText($e->getMessage()),
                    'calloutClass' => 'danger',
                ));
        }
    }

    /**
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $className = $this->getClassName();

        if ($className::destroy($id)) {
            return Redirect::route($this->getRouteNameForEntity());
        }
    }
}