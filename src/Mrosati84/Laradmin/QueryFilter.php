<?php

namespace Mrosati84\Laradmin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;

class QueryFilter
{
    const EMPTY_STRING = '';

    /**
     * the filters array
     * @var array
     */
    private $filters;

    /**
     * class constructor
     * @param array $filters
     */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * determines if this entity has filters defined
     * @return boolean
     */
    public function hasFilters()
    {
        return count($this->filters) > 0;
    }

    /**
     * build an array containing all the necessary HTML inputs for the filters
     * @return array
     */
    public function buildFiltersInputs()
    {
        $filtersInputs = array();

        foreach ($this->filters as $filterName => $filterValue) {
            array_push($filtersInputs, array(
                'label' => Form::label($filterName),
                'widget' => Form::text($filterName, Input::old($filterName), array('class' => 'form-control'))
            ));
        }

        return $filtersInputs;
    }

    /**
     * get filters form form view
     * @return View
     */
    public function getFiltersForm()
    {
        return ($this->hasFilters())
            ? View::make('laradmin::forms/filters', array(
                'filtersInputs' => $this->buildFiltersInputs())
            )
            : self::EMPTY_STRING;
    }

    /**
     * filter a Eloquent collection
     * @param  Collection $results
     * @return Collection
     */
    public function filter($results)
    {
        return $results;
    }
}