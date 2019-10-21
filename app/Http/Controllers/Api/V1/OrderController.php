<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\OrderRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class OrderController extends ApiResourceController
{

    public $_repository;

    public function __construct(OrderRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function rules($value = '')
    {
        $rules = [];

        if ($value == 'store') {
            $rules['product_id'] =  'required';
            $rules['from_date'] =  'required';
            $rules['to_date'] =  'required';
        }

        if ($value == 'update') {
            $rules['id'] =  'required';
        }


        if ($value == 'destroy') {
            $rules['id'] =  'required';

        }

        if ($value == 'show') {
            $rules['id'] =  'required';

        }

        if ($value == 'index') {
            $rules['pagination'] =  'nullable|in:true,false';

        }

        return $rules;
    }

    public function input($value = '')
    {
        $input = request()->only('id', 'product_id', 'from_date', 'to_date', 'number_of_items', 'address', 'address_secondary', 'address_type', 'address_id', 'nearest_check_point');
        $input['user_id'] = request()->user() ? request()->user()->id : null;
        
        return $input;
    }

        //Create single record
    public function store(Request $request)
    {
        $request->request->add(['method_type' => 'store']);

        $rules = $this->rules(__FUNCTION__);
        $input = $this->input(__FUNCTION__);

        $messages = $this->messages(__FUNCTION__);

        $this->validate($request, $rules, $messages);

        if (empty($input['address_id'])) {

            $userAddress = [
                'user_id' => $input['user_id'],
                'city_id' => 1,
                'address' => $input['address'],
                'address_secondary' => $input['address_secondary'],
                'nearest_check_point' => $input['nearest_check_point']
            ];

            $input['address_id'] = \App\Data\Models\UserAddress::create($userAddress)['id'];

        }

        unset($input['address'], $input['address_type'], $input['address_secondary'], $input['nearest_check_point']);

        $data = $this->_repository->create($input);

        $output = ['data' => $data, 'message' => $this->responseMessages(__FUNCTION__)];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);

    }

    public function validateOrderDate()
    {
        $input = $this->input(__FUNCTION__);

        $data = $this->_repository->validateOrderDate($input);

        $output = ['data' => $data, 'message' => $this->responseMessages($data ? __FUNCTION__ : 'order_validated')];

        $code = !!$data ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return response()->json($output, $code);

    }

    public function itemCount(Request $request)
    {
        $data = $this->_repository->findTotal();

        $output = [
                'data' => $data,
        ];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);
    }

    public function responseMessages ($value = '')
    {
        $messages = [
            'store' => 'Record created successfully.',
            'update' => 'Record updated successfully.',
            'destroy' => 'Record deleted successfully.',
            'validateOrderDate' => 'Prodcut unavailable on specified dates',
            'order_validated' => 'Prodcut available on specified dates'
        ];

        return !empty($messages[$value]) ? $messages[$value] : '';
    }

}
