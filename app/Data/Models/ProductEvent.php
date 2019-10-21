<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class ProductEvent extends Model
{
    //
	use  InsertOnDuplicateKey;
}
