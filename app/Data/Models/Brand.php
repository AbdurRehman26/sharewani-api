<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Brand extends Model
{
    //
    use  InsertOnDuplicateKey;
}
