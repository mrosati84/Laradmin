<?php

namespace Mrosati84\Laradmin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mrosati84\Laradmin\BaseAdminController;

class BaseAdmin extends BaseAdminController
{
    const RELATIONSHIP_TYPE   = 0;
    const RELATIONSHIP_MODEL  = 1;
    const RELATIONSHIP_STRING = 2;
    const UNASSOCIATE         = '';

    const FIRST_ITEM          = 0;

    const EMPTY_INDEX         = '';
    const EMPTY_VALUE         = '---';

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
    public function getRouteNameForEntity($action = 'index')
    {
        return $this->getPrefix() . '.' .
            $this->getLowercaseClassName() . '.' . $action;
    }

    /**
     * returns text wrapper in <pre> tag
     * @param  string $text
     * @return string
     */
    public function getPreformattedText($text)
    {
        return '<pre>' . $text . '</pre>';
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

    /**
     * @return callable
     */
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
                $viewData = array(
                    'prefix' => $this->getPrefix(),
                    'fieldValue' => $fieldValue,
                    'relationshipModel' => $relationshipModel,
                    'relationshipString' => $relationshipString
                );

                if ($fieldValue) {
                    switch($relationshipType) {
                        case 'BelongsTo':
                        case 'HasOne':
                        return View::make('laradmin::fields/' . strtolower($relationshipType), $viewData);

                        case 'HasMany':
                        case 'BelongsToMany':
                        return (count($fieldValue))
                            ? View::make('laradmin::fields/' . strtolower($relationshipType), $viewData)
                            : null;
                    }
                }
            }

            // default rendering, just return the flat value
            return $fieldValue;
        };
    }

    /**
     * @return callable
     */
    public function getDefaultFormFieldRenderer()
    {
        return function($actionName, $className, $fieldName, $fieldValue=null) {
            $fieldType = $this->getFieldType($className, $fieldName);
            $customRenderMethod = $this->getCustomRenderMethodName($actionName, $fieldName);

            if (method_exists($this, $customRenderMethod)) {
                // call custom rendering method
                return $this->$customRenderMethod($fieldValue);
            }

            // default view data
            $viewData = array(
                'fieldName' => $fieldName,
                'fieldValue' => $fieldValue
            );

            // default rendering
            switch($fieldType) {
                case 'string':
                case 'email':
                case 'password':
                case 'textarea':
                case 'number':
                case 'datetime':

                return View::make('laradmin::form-fields/' . $fieldType, $viewData);
            }

            // handle relationships
            $relationship = explode(':', $fieldType);

            $relationshipType = $relationship[self::RELATIONSHIP_TYPE];
            $relationshipModel = $relationship[self::RELATIONSHIP_MODEL];
            $relationshipString = $relationship[self::RELATIONSHIP_STRING];

            switch($relationshipType) {
                /** =======================================
                 * HAS MANY / BELONGS TO MANY RELATIONSHIPS
                 * ===================================== */
                case 'HasMany':
                case 'BelongsToMany':
                return View::make('laradmin::form-fields/' . strtolower($relationshipType), array(
                    'fieldName' => $fieldName,
                    'fieldValue' => $fieldValue,
                    'relationshipModel' => $relationshipModel,
                    'relationshipString' => $relationshipString,
                ));

                /** =================================
                 * HAS ONE / BELONGS TO RELATIONSHIPS
                 * =============================== */
                case 'HasOne':
                case 'BelongsTo':
                $lists = $relationshipModel::lists($relationshipString, 'id');
                $lists[self::EMPTY_INDEX] = self::EMPTY_VALUE;
                ksort($lists);

                return View::make('laradmin::form-fields/' . strtolower($relationshipType), array(
                    'fieldName' => $fieldName,
                    'fieldValue' => ($fieldValue) ? $fieldValue->id : 0,
                    'lists' => $lists
                ));
            }
        };
    }

    /**
     * get the validation rules for entity. Parent method returns an empty
     * array by default, this is intended to be overridden in child classes
     * @return array
     */
    public function getValidationRules()
    {
        return array();
    }

    public function getFilters()
    {
        return array();
    }

    /**
     * get the validator object for this entity
     * @return Validator
     */
    public function getValidator()
    {
        return Validator::make(
            Input::all(),
            $this->getValidationRules()
        );
    }

    /**
     * determines if a field type is a relationship
     * @param  string  $relationship the relationship type
     * @return boolean
     */
    private function isRelationship($relationship) {
        return count($relationship) > 1;
    }

    /**
     * pre-process an input field, before saving it into the model
     * @param  string $fieldName
     * @param  mixed $fieldValue
     * @return mixed
     */
    public function preprocessInputField($fieldName, $fieldValue)
    {
        $customPreprocessMethodName = 'preprocess' . ucfirst(camel_case(strtolower($fieldName)));

        if (method_exists($this, $customPreprocessMethodName)) {
            return $this->$customPreprocessMethodName($fieldValue);
        }

        return $fieldValue;
    }

    /**
     * @param $record the Eloquent row
     * @return void
     */
    public function saveRelatedModels($record)
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
                    $lowercaseClassName = $this->getLowercaseClassName();
                    $relatedResults = array();

                    // dissociate all the related models from the record
                    if (!$relatedIndexes) {
                        foreach($record->$fieldName as $relatedResult) {
                            $relatedResult->$lowercaseClassName()->dissociate();
                            $relatedResult->save();
                        }

                        break;
                    }

                    // handle differences between what is transmitted and
                    // what is already associated to the record
                    if (count($relatedIndexes) > 0) {
                        // make a diff between the transmitted ids and the
                        // ids already associated to the record
                        $alreadyAssociated = $record->$fieldName->lists('id');
                        $idsToUnassociate = array_values(array_diff($alreadyAssociated, $relatedIndexes));

                        // unassociate one by one
                        foreach($idsToUnassociate as $idToUnassociate) {
                            $modelToDissociate = $relationshipModel::find($idToUnassociate);

                            $modelToDissociate
                                ->$lowercaseClassName()
                                ->dissociate();

                            $modelToDissociate->save();
                        }
                    }

                    // associate transmitted ids to the record
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

                    // dissociate
                    if (!$relatedIndexes) {
                        $toDetach = $record->$fieldName->lists('id');
                        $record->$fieldName()->detach($toDetach);

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
}
