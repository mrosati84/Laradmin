<?php

namespace Mrosati84\Laradmin;

class QueryFilter
{
    /**
     * class constructor
     * @param array $filters
     */
    public function __construct($filters)
    {

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