<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\City;

class CityRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of City Class.
     *
     * @var object
     * @access public
     *
     **/
    public $model;

    /**
     *
     * This is the prefix of the cache key to which the
     * App\Data\Repositories data will be stored
     * App\Data\Repositories Auto incremented Id will be append to it
     *
     * Example: City-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'City';
    protected $_cacheTotalKey = 'total-City';

    public function __construct(City $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
