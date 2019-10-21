<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\UserAddress;
use App\Traits\AbstractMethods;

class UserAddressRepository extends AbstractRepository implements RepositoryContract
{
    use AbstractMethods;
    /**
     *
     * These will hold the instance of UserAddress Class.
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
     * Example: UserAddress-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'UserAddress';
    protected $_cacheTotalKey = 'total-UserAddress';

    public function __construct(UserAddress $model)
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
    /**
     *
     * This method will fetch all exsiting models
     * and will return output back to client as json
     *
     * @access public
     * @param bool $pagination
     * @param int $perPage
     * @param array $input
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function findByAll($pagination = false, $perPage = 10, array $input = [])
    {
        $this->builder = $this->searchCriteria($input);
        
        return parent::findByAll($pagination, $perPage, $input);
    }
    
}
