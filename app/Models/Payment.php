<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "orders";
    protected $fillable = [
        "user_id",
        "amount",
        "order_no",
        "status",
    ];
}