<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use  InsertOnDuplicateKey, SoftDeletes;

    const STATUSES = [
        0 => 'Pending',
        1 => 'Accepted',
        -1 => 'Rejected'
    ];

    public $searchables = [
        'user_id'
    ];
}
