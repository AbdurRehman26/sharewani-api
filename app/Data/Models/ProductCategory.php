<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class ProductCategory extends Model
{
    //
	use  InsertOnDuplicateKey;
}
