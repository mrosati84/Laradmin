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
    const UNASSOCIATE         = 0;

    const FIRST_ITEM          = 0;

    const EMPTY_ITEM          = '---';

    private $className;
    private $lowercaseClassName;
    private $fields;
    private $prefix;

    public function __construct($className)
    {
        $this->className = $className;
        $this->lowercaseClassName = strtolower($className);
        $this->fields = Config::get('laradmin::entities.' . $className . '.fields');
        $this->prefix = Config::get('laradmin::prefix');
    }

    /**
     * returns the capitalized class name
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * get the lower-cased class name
     * @return string
     */
    public function getLowercaseClassName()
    {
        return $this->lowercaseClassName;
    }

    /**
     * get the fields for this entity
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * get the route prefix for laradmin
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * get the route string for an entity, given an action name
     * @param  string $action the action name
     * @return string
     */
    private function getRouteForEntity($action = 'index')
    {
        return $this->getPrefix() . '.' .
            $this->getLowercaseClassName() . '.' . $action;
    }

    /**
     * get the field type
     * @param  string $className the class name
     * @param  string $fieldName the field name
     * @return string
     */
    private function getFieldType($className, $fieldName)
    {
        return Config::get('laradmin::entities.' . $className . '.fields.' . $fieldName . '.type');
    }

    /**
     * get the custom render method name as a string
     * @param  string $actionName the action name
     * @param  string $fieldName  the field name
     * @return string
     */
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
            $fieldType = Config::get('laradmin::entities.' . $className .
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
                    'fieldValue' => ($fieldValue) ? $fieldValue : date('Y-m-d H:i:s')
                ));
            }

            // handle relationships
            $relationship = explode(':', $fieldType);

            $relationshipType = $relationship[self::RELATIONSHIP_TYPE];
            $relationshipModel = $relationship[self::RELATIONSHIP_MODEL];
            $relationshipString = $relationship[self::RELATIONSHIP_STRING];

            switch($relationshipType) {
                /** ====================
                 * HAS MANY RELATIONSHIP
                 * ================== */
                case 'HasMany':
                return View::make('laradmin::form-fields/hasmany', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue,
                    'relationshipModel' => $relationshipModel,
                    'relationshipString' => $relationshipString,
                ));

                /** ===========================
                 * BELONGS TO MANY RELATIONSHIP
                 * ========================= */
                case 'BelongsToMany':
                return View::make('laradmin::form-fields/belongstomany', array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue,
                    'relationshipModel' => $relationshipModel,
                    'relationshipString' => $relationshipString,
                ));

                /** ===================
                 * HAS ONE RELATIONSHIP
                 * ================= */
                case 'HasOne':
                $lists = $relationshipModel::lists($relationshipString, 'id');
                $lists[self::FIRST_ITEM] = self::EMPTY_ITEM;
                ksort($lists);

                return View::make('laradmin::form-fields/hasone', array(
                    'fieldName' => $fieldName,
                    'lists' => $lists,
                    'default' => ($fieldValue) ? $fieldValue->id : 0,
                    'attributes' => array('class' => 'form-control')
                ));

                /** ======================
                 * BELONGS TO RELATIONSHIP
                 * ==================== */
                case 'BelongsTo':
                $lists = $relationshipModel::lists($relationshipString, 'id');
                $lists[self::FIRST_ITEM] = self::EMPTY_ITEM;
                ksort($lists);

                return View::make('laradmin::form-fields/belongsto', array(
                    'fieldName' => $fieldName,
                    'lists' => $lists,
                    'default' => ($fieldValue) ? $fieldValue->id : 0,
                    'attributes' => array('class' => 'form-control')
                ));
            }
        };
    }

    /**
     * determines if a field type is a relationship
     * @param  string  $relationship the relationship type
     * @return boolean
     */
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

                    // dissociate related model
                    if ($relatedIndex == self::UNASSOCIATE) {
                        $record->$fieldName()->dissociate();
                    }

                    // associate model
                    if (count($relatedResult)) {
                        $record->$fieldName()->associate($relatedResult);
                    }

                    $record->save();

                    break;

                    /** ========================
                     * HAS ONE RELATIONSHIP TYPE
                     * ====================== */
                    case 'HasOne':
                    $relatedIndex = Input::get($fieldName);
                    $relatedResult = $relationshipModel::find($relatedIndex);
                    $className = $this->getClassName();
                    $lowercaseClassName = $this->getLowercaseClassName();

                    if ($relatedIndex == self::UNASSOCIATE) {
                        if ($record->$fieldName) {
                            $associatedRecord = $record->$fieldName;
                            $associatedRecord->$lowercaseClassName()->dissociate();

                            $associatedRecord->save();

                            break;
                        }
                    }

                    if ($relatedResult) {
                        $record->$fieldName()->save($relatedResult);
                    }

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
