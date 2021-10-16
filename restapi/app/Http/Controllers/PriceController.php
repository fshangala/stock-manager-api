<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    public function prices(Request $request)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $prices = Price::all();
        $res["success"] = true;
        if (count($prices) > 0){
            $res["data"] = $prices;
            $res["message"] = "Data retrieved!";
        } else {
            $res["message"] = "No Data to show!";
        }

        return response($res, $statusCode);
    }

    public function ordersCreate(Request $request)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $this->validate($request, [
            "name"=>"required",
            "quantity"=>"required",
            "price"=>"required"
        ], 
        [
            "required"=>"Please fill this field :attribute"
        ]);

        try {
            $save = Order::create($request->all());
            $res["success"]=true;
            $res["message"]="Order successfully added.";
            $res["data"]= $save;
        } catch (Exception $ex) {
            $statusCode=500;
            $res["message"]=$ex->getMessage();
        }

        return response($res, $statusCode);
    }

    public function ordersUpdate(Request $request)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $this->validate($request, [
            "order_id"=>"required"
        ], 
        [
            "required"=>"Please fill this field :attribute"
        ]);

        try {
            $order = Order::find($request->input("order_id"));
            if($order){
                $order->update($request->all());
                $res["success"]=true;
                $res["message"]="Order successfully updated.";
                $res["data"]= $order;
            } else {
                $res["message"]="Could not find order.";
                $statusCode = 404;
            }
        } catch (Exception $ex) {
            $statusCode=500;
            $res["message"]=$ex->getMessage();
        }

        return response($res, $statusCode);
    }

    public function ordersDelete(Request $request)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $this->validate($request, [
            "order_id"=>"required"
        ], 
        [
            "required"=>"Please fill this field :attribute"
        ]);

        try {
            $order = Order::find($request->input("order_id"));
            if($order){
                $order->delete();
                $res["success"]=true;
                $res["message"]="Order successfully deleted.";
            } else {
                $res["message"]="Could not find order.";
                $statusCode = 404;
            }
        } catch (Exception $ex) {
            $statusCode=500;
            $res["message"]=$ex->getMessage();
        }

        return response($res, $statusCode);
    }
}

?>