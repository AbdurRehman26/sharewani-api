<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Category extends Model
{
    //
	use  InsertOnDuplicateKey;
}
