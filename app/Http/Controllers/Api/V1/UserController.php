<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\UserRepository;
use App\Laravue\Models\User;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Session;
use JWTAuth;


class UserController extends ApiResourceController{

    public $_repository;

    public function __construct(UserRepository $repository){
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
        $input = request()->only('id', 'email', 'name', 'pagination', 'page', 'phone_number');

        return $input;
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

    public function signIn(Request $request){

        $credentials = $request->only('email' , 'provider_id' , 'image');

        if(empty($credentials['email'])){
            $request->request->add(['email' => request()->only('provider_id')['provider_id']]);
        }

        if(empty($credentials['email'])){
            $credentials['email'] = $credentials['provider_id'];
        }


        $user = User::where('email', '=' , $credentials['email'])->first();


        if (!empty($user)) {

            $token = JWTAuth::fromUser($user);

            if ($token) {

                Session::put('token', $token);
                $output = ['message' => 'Successfully Logged in' , 'data' => ['token' => $token, 'user' => $user]];
                return response()->json($output , 200);
            }
        }

        parent::store($request);

        if($credentials['email']){
            $user = User::where('email', '=' , $credentials['email'])->first();

            $token = JWTAuth::fromUser($user);

            $user->access_token = $token;
            $user->first_time_user = true;

            if ($token) {
                Session::put('token', $token);

                $output = ['message' => 'success' , 'data' => ['token' => $token, 'user' => $user]];
                return response()->json($output , 200);
            }
        }

        return true;
    }


}
