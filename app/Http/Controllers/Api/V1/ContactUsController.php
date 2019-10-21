<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\ContactUsRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class ContactUsController extends ApiResourceController{
    
    public $_repository;

    public function __construct(ContactUsRepository $repository){
        $this->_repository = $repository;
    }

    public function rules($value=''){
        $rules = [];

        if($value == 'store'){

            $rules['message'] = 'required';
            $rules['name'] = 'required';
            $rules['email'] = 'required';
        
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
        
        $input = request()->only('id', 'name', 'email', 'subject', 'message');
        $input['user_id'] = request()->user() ? request()->user()->id : null;

        return $input;
    }


    public function responseMessages ($value = '')
    {
        $messages = [
            'store' => 'Thank you for your feedback. We will get back to you shortly.',
        ];

        return !empty($messages[$value]) ? $messages[$value] : '';
    }

}