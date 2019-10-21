<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Product extends Model
{
    //
	use  InsertOnDuplicateKey;

    protected $casts = [
        'images' => 'array'
    ];

    public $searchables = [
        'brand_id', 'color_id', 'original_price', 'fabric_age_id', 'size_id',
    ];

}
