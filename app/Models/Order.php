<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = [
        "user_id",
        "product_id",
        "order_no",
        "unit_price",
        "status",
        "total"
    ];
}