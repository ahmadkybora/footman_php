<?php

namespace App\Controllers\Panel\Order;


use App\Controllers\Controller;
use App\Layer\Middleware;
use App\Layer\Role;
use App\Models\Order;
use App\Providers\Redirect;

class OrderController extends Controller
{
    private $table_name = "orders";

    public function __construct()
    {
        if(!Middleware::middleware('admin'))
            Redirect::to('/login');
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show()
    {
        $orders = Order::with('orderDetails')->get();
        echo json_encode($orders); exit;

        $total = Order::all()->count();
        list($orders, $links) = paginate(10, $total, $this->table_name, new Order);
        return view('admin/transactions/order', compact('orders', 'links'));
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}