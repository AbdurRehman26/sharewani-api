<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'address_secondary', 'nearest_check_point', 'user_id', 'city_id', 'created_at', 'updated_at'
    ];    


    public $searchables = [
    	'user_id'
    ];
}
