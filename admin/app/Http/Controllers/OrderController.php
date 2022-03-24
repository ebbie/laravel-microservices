<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index()
    {
        if(Gate::allows('view','orders')) {
            $order = Order::paginate();
            return OrderResource::collection($order);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function show($id)
    {
        if(Gate::allows('view','orders')) {
            return new OrderResource(Order::find($id));
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }

    public function export()
    {
        if(Gate::allows('view','orders')) {

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=orders.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",

            ];

            $callback = function() {
                $orders = Order::all();
                $file = fopen('php://output','w');

                //Header Row
                fputcsv($file, ['ID','Name', 'Email', 'Product Title', "Price", "Quantity"]);

                //BOdy
                foreach($orders as $order){
                    fputcsv($file, [$order->id, $order->name, $order->email,'','', '']);

                    foreach($order->orderItems as $orderItem)
                    {
                        fputcsv($file, ['','', '',$orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                    }
                }
                fclose($file);
            };

            return \Response::stream($callback, 200, $headers);
        } else {
            return "You are not authorized to do this. Please look at the code.";
        }
    }
}
