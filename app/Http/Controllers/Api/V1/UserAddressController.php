<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\UserAddressRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class UserAddressController extends ApiResourceController{
    
    public $_repository;

    public function __construct(UserAddressRepository $repository){
        $this->_repository = $repository;
    }

    public function rules($value=''){
        $rules = [];

        if($value == 'store'){
            

        }

        if($value == 'update'){

            $rules['id'] =  'required';

        }


        if($value == 'destroy'){

            $rules['id'] =  'required';

        }

        if($value == 'show'){

            $rules['id'] =  'required';

        }

        if($value == 'index'){
         
            $rules['pagination'] =  'nullable|in:true,false';

        }

        return $rules;
    
    }

    public function input($value=''){
        $input = request()->only('id');
        $input['user_id'] = request()->user() ? request()->user()->id : null;
        
        return $input;
    }
}