<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Role;

class RoleRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Role Class.
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
     * Example: Role-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Role';
    protected $_cacheTotalKey = 'total-Role';

    public function __construct(Role $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
