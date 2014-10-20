<?php

namespace Mrosati84\Laradmin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class BaseAdminController extends Controller
{
    const RELATIONSHIP_TYPE   = 0;
    const RELATIONSHIP_MODEL  = 1;
    const RELATIONSHIP_STRING = 2;

    private $className;
    private $lowercaseClassName;
    private $fields;
    private $prefix;

    public function __construct($className)
    {
        $this->className = $className;
        $this->lowercaseClassName = strtolower($className);
        $this->fields = Config::get('laradmin.entities.' . $className . '.fields');
        $this->prefix = Config::get('laradmin.prefix');
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getLowercaseClassName()
    {
        return $this->lowercaseClassName;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    private function getRouteForEntity($action = 'index')
    {
        return $this->getPrefix() . '.' .
            $this->getLowercaseClassName() . '.' . $action;
    }

    private function getFieldType($className, $fieldName)
    {
        return Config::get('laradmin.entities.' . $className . '.fields.' . $fieldName . '.type');
    }

    private function getCustomRenderMethodName($actionName, $fieldName)
    {
        return 'render' . ucfirst($actionName) . ucfirst(camel_case(strtolower($fieldName)));
    }

    public function getDefaultFieldRenderer()
    {
        return function($actionName, $className, $fieldName, $fieldValue) {
            $fieldType = $this->getFieldType($className, $fieldName);
            $customRenderMethod = $this->getCustomRenderMethodName($actionName, $fieldName);

            if (method_exists($this, $customRenderMethod)) {
                // call custom rendering method
                return $this->$customRenderMethod($fieldValue);
            }

            $relationship = explode(':', $fieldType);

            if ($this->isRelationship($relationship)) {
                $relationshipType = $relationship[self::RELATIONSHIP_TYPE];
                $relationshipModel = $relationship[self::RELATIONSHIP_MODEL];
                $relationshipString = $relationship[self::RELATIONSHIP_STRING];

                if ($fieldValue) {
                    switch($relationshipType) {
                        case 'BelongsTo':
                        return View::make('laradmin::fields/belongsto', array(
                            'prefix' => $this->getPrefix(),
                            'fieldValue' => $fieldValue,
                            'relationshipModel' => $relationshipModel,
                            'relationshipString' => $relationshipString
                        ));

                        case 'HasOne':
                        return View::make('laradmin::fields/hasone', array(
                            'prefix' => $this->getPrefix(),
                            'fieldValue' => $fieldValue,
                            'relationshipModel' => $relationshipModel,
                            'relationshipString' => $relationshipString
                        ));

                        case 'HasMany':
                        if (count($fieldValue)) {
                            return View::make('laradmin::fields/hasmany', array(
                                'prefix' => $this->getPrefix(),
                                'fieldValue' => $fieldValue,
                                'relationshipModel' => $relationshipModel,
                                'relationshipString' => $relationshipString
                            ));
                        } else {
                            // relationship is empty
                            return null;
                        }

                        case 'BelongsToMany':
                        if (count($fieldValue)) {
                            return View::make('laradmin::fields/belongstomany',
                                array(
                                    'prefix' => $this->getPrefix(),
                                    'fieldValue' => $fieldValue,
                                    'relationshipModel' => $relationshipModel,
                                    'relationshipString' => $relationshipString
                                )
                            );
                        } else {
                            // relationship is empty
                            return null;
                        }
                    }
                }
            }

            // default rendering, just return the flat value
            return $fieldValue;
        };
    }

    public function getDefaultFormFieldRenderer()
    {
        return function($actionName, $className, $fieldName, $fieldValue=null) {
            $fieldType = Config::get('laradmin.entities.' . $className .
                '.fields.' . $fieldName . '.type');

            $customRenderMethod = 'render' . ucfirst($actionName) .
                ucfirst(camel_case(strtolower($fieldName)));

            if (method_exists($this, $customRenderMethod)) {
                // call custom rendering method
                return $this->$customRenderMethod();
            }

            // default rendering
            switch($fieldType) {
                case 'string':
                return View::make('laradmin::form-fields/string', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue
                ));

                case 'email':
                return View::make('laradmin::form-fields/email', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue
                ));

                case 'text':
                return View::make('laradmin::form-fields/textarea', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue
                ));

                case 'number':
                return View::make('laradmin::form-fields/number', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue
                ));

                case 'datetime':
                return View::make('laradmin::form-fields/datetime', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue
                ));
            }

            // handle relationships
            $relationship = explode(':', $fieldType);

            $relationshipType = $relationship[self::RELATIONSHIP_TYPE];
            $relationshipModel = $relationship[self::RELATIONSHIP_MODEL];
            $relationshipString = $relationship[self::RELATIONSHIP_STRING];

            switch($relationshipType) {
                case 'HasMany':
                return Form::select($fieldName . '[]',
                    $relationshipModel::lists($relationshipString, 'id'),
                    ($fieldValue) ? $fieldValue->lists('id') : null,
                    array('multiple', 'class' => 'form-control')
                );

                case 'BelongsToMany':
                return Form::select($fieldName . '[]',
                    $relationshipModel::lists($relationshipString, 'id'),
                    ($fieldValue) ? $fieldValue->lists('id') : null,
                    array('multiple', 'class' => 'form-control')
                );

                case 'BelongsTo':
                return Form::select($fieldName,
                    $relationshipModel::lists($relationshipString, 'id'),
                    ($fieldValue) ? $fieldValue->id : null,
                    array('class' => 'form-control')
                );

                case 'HasOne':
                return Form::select($fieldName,
                    $relationshipModel::lists($relationshipString, 'id'),
                    ($fieldValue) ? $fieldValue->id : null,
                    array('class' => 'form-control')
                );
            }
        };
    }

    private function isRelationship($relationship) {
        return count($relationship) > 1;
    }

    private function saveRelatedModels($record)
    {
        $fields = $this->getFields();

        foreach($fields as $fieldName => $fieldProperties) {
            $relationship = explode(':', $fieldProperties['type']);

            if ($this->isRelationship($relationship)) {
                $relationshipType = $relationship[self::RELATIONSHIP_TYPE];
                $relationshipModel = $relationship[self::RELATIONSHIP_MODEL];
                $relationshipString = $relationship[self::RELATIONSHIP_STRING];

                switch($relationshipType) {
                    /** ===========================
                     * BELONGS TO RELATIONSHIP TYPE
                     * ========================= */
                    case 'BelongsTo':
                    $relatedIndex = Input::get($fieldName);
                    $relatedResult = $relationshipModel::find($relatedIndex);
                    $lowercaseClassName = $this->getLowercaseClassName();

                    $record->$fieldName()->associate($relatedResult);
                    $record->save();

                    break;

                    /** ========================
                     * HAS ONE RELATIONSHIP TYPE
                     * ====================== */
                    case 'HasOne':
                    $relatedIndex = Input::get($fieldName);
                    $relatedResult = $relationshipModel::find($relatedIndex);
                    $lowercaseClassName = $this->getLowercaseClassName();

                    $record->$fieldName()->save($relatedResult);
                    $record->save();

                    break;

                    /** =========================
                     * HAS MANY RELATIONSHIP TYPE
                     * ======================= */
                    case 'HasMany':
                    $relatedIndexes = Input::get($fieldName);

                    if (!count($relatedIndexes)) {
                        break;
                    }

                    $relatedResults = array();

                    foreach ($relatedIndexes as $relatedIndex) {
                        array_push($relatedResults,
                            $relationshipModel::find($relatedIndex));
                    }

                    $record
                        ->$fieldName()
                        ->saveMany($relatedResults);
                    break;

                    /** ================================
                     * BELONGS TO MANY RELATIONSHIP TYPE
                     * ============================== */
                    case 'BelongsToMany':
                    $relatedIndexes = Input::get($fieldName);

                    if (!count($relatedIndexes)) {
                        break;
                    }

                    $record
                        ->$fieldName()
                        ->sync($relatedIndexes);
                    break;
                } // switch
            } // if
        } // foreach
    }

    public function index()
    {
        $className = $this->getClassName();
        $results = $className::all();

        return View::make('laradmin::index', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFieldRenderer(),

            'results' => $results
        ));
    }

    public function create()
    {
        $className = $this->getClassName();
        $results = $className::all();

        return View::make('laradmin::create', array(
            // TODO: these sould be always injected in views
            'prefix' => $this->getPrefix(),
            'className' => $className,
            'lowercaseClassName' => $this->getLowercaseClassName(),
            'fields' => $this->getFields(),
            'renderer' => $this->getDefaultFormFieldRenderer(),
            'storeRoute' => $this->getRouteForEntity('store'),

            'results' => $results
        ));
    }

    public function store()
    {
        $className = $this->getClassName();
        $fields = $this->getFields();

        $newRecord = new $className;

        // save regular columns
        foreach($fields as $fieldName => $fieldProperties) {
            switch ($fieldProperties['type'] ) {
                case 'string':
                case 'number':
                case 'text':
                case 'email':
                case 'datetime':
                    $newRecord->$fieldName = Input::get($fieldName);
                    break;
            }
        }

        // persist record
        if ($newRecord->save()) {
            $this->saveRelatedModels($newRecord);
            return Redirect::route($this->getRouteForEntity());
        }
    }

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
            'updateRoute' => $this->getRouteForEntity('update'),

            'results' => $results
        ));
    }

    public function update($id)
    {
        $className = $this->getClassName();
        $fields = $this->getFields();

        $record = $className::find($id);

        // save regular columns
        foreach($fields as $fieldName => $fieldProperties) {
            switch ($fieldProperties['type'] ) {
                case 'string':
                case 'number':
                case 'text':
                case 'email':
                case 'datetime':
                    $record->$fieldName = Input::get($fieldName);
                    break;
            }
        }

        if ($record->save()) {
            $this->saveRelatedModels($record);
            return Redirect::route($this->getRouteForEntity());
        }
    }

    public function destroy($id)
    {
        $className = $this->getClassName();

        if ($className::destroy($id)) {
            return Redirect::route($this->getRouteForEntity());
        }
    }
}
