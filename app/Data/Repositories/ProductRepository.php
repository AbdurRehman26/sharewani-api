<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Product;
use App\Traits\AbstractMethods;

class ProductRepository extends AbstractRepository implements RepositoryContract
{
    use AbstractMethods;
    /**
     *
     * These will hold the instance of Product Class.
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
     * Example: Product-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Product';
    protected $_cacheTotalKey = 'total-Product';

    public function __construct(Product $model)
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


        if(!empty($input['event_id'])){
            $productIds = \App\Data\Models\ProductEvent::where('event_id', (int)$input['event_id'])->get()->pluck('product_id')->toArray();
            $this->builder = $this->builder->whereIn('id', $productIds);
        }


        return parent::findByAll($pagination, $perPage, $input);
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

        $data->size = app('SizeRepository')->findById($data->size_id);
        $data->brand = app('BrandRepository')->findById($data->brand_id);
        $data->fabric_age = app('FabricAgeRepository')->findById($data->fabric_age_id);
        $data->color = app('ColorRepository')->findById($data->color_id);
      
        if(request()->user()){

            $criteria = [
                'product_id' => $data->id,
                'user_id' => request()->user()->id
            ];

            $data->my_order = \App\Data\Models\Order::where($criteria)->first();

        }

        $data->image_paths = [];

        if (!empty($data->images)) {
            foreach ($data->images as $key => $value) {
                if (substr($value, 0, 8) != "https://" && substr($value, 0, 8) != "http://") {
                    $data->image_paths[] = url('storage/product/'.$value);
                } else {
                    $data->image_paths[] = $value;
                }
            }
        }

        $data->categories = $this->model->join('product_categories', function ($join) use ($data) {
            $join->on('products.id', 'product_categories.product_id')
                ->where('products.id', $data->id);
        })->join('categories', function ($join) {
            $join->on('categories.id', 'product_categories.category_id');
        })
        ->select('categories.name', 'categories.id')
        ->get();


        $data->events = $this->model->join('product_events', function ($join) use ($data) {
            $join->on('products.id', 'product_events.product_id')->where('products.id', $data->id);
        })->join('events', function ($join) {
            $join->on('events.id', 'product_events.event_id');
        })
        ->select('events.name', 'events.id')
        ->get();

        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();

        if (!empty($details['dashboard_stats'])) {
            $data->total_orders = \App\Data\Models\Order::where('product_id', $data->id)->count();
            $data->total_accepted_orders = \App\Data\Models\Order::where(['product_id' => $data->id, 'status' => 1])->count();
            $data->total_pending_orders = \App\Data\Models\Order::where(['product_id' => $data->id, 'status' => 0])->count();
        }

        return $data;
    }


}
