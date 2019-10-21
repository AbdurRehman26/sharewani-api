<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Color extends Model
{
    //
    use  InsertOnDuplicateKey;
}
