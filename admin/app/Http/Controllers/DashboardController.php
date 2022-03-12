<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChartResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function chart()
    {
        if(Gate::allows('view','orders')) {
            $orders = Order::query()
                ->join('order_items','orders.id','=','order_items.order_id')
                ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity*order_items.price) as sum")
                ->groupBy('date')
                ->get();

            return ChartResource::collection($orders);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }
}
