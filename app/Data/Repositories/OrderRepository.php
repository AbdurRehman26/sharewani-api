<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Order;
use App\Traits\AbstractMethods;

class OrderRepository extends AbstractRepository implements RepositoryContract
{
    use AbstractMethods;
    /**
     *
     * These will hold the instance of Order Class.
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
     * Example: Order-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Order';
    protected $_cacheTotalKey = 'total-Order';

    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->builder = $model;
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
    
    /**
     *
     * This method will create a new model
     * and will return output back to client as json
     *
     * @access public
     * @param array $data
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function create(array $data = [])
    {

        $data['deleted_at'] = null;
        $order = Order::insertOnDuplicateKey($data);
        $retRetId = \DB::getPdo()->lastInsertId();
        return $this->findById($retRetId);
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

        $data->user = app('UserRepository')->findById($data->user_id);

        $data->product = app('ProductRepository')->findById($data->product_id);

        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();

        $data->order_status = Order::STATUSES[$data->status];

        return $data;
    }

    public function validateOrderDate($input)
    {

        $data = $this->model->where(function($where) use ($input){

            $where->where('from_date' , '<=', date($input['from_date']))
            ->where('to_date', '>=', date($input['from_date']))
            ->where('status', 1);

        })->orWhere(function($where) use ($input){

            $where->where('from_date' , '<=', date($input['to_date']))
            ->where('to_date', '>=', date($input['to_date']))
            ->where('status', 1);

        })->first();

        return $data;
    }

}
