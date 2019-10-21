<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Event extends Model
{
    //
	use  InsertOnDuplicateKey;
}
