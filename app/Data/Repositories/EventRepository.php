<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Event;

class EventRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Event Class.
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
     * Example: Event-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Event';
    protected $_cacheTotalKey = 'total-Event';

    public function __construct(Event $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
