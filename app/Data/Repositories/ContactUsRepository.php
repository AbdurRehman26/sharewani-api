<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\ContactUs;

class ContactUsRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of ContactUs Class.
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
     * Example: ContactUs-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'ContactUs';
    protected $_cacheTotalKey = 'total-ContactUs';

    public function __construct(ContactUs $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }

        /**
     *
     * This method will fetch single model
     * and will return output back to client as json
     *
     * @access public
     * @param $id
     * @param bool $refresh
     * @param bool $details
     * @param bool $encode
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function findById($id, $refresh = false, $details = false, $encode = true)
    {        
        $data = parent::findById($id, $refresh, $details, $encode);
        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
        return $data;
    }
}
