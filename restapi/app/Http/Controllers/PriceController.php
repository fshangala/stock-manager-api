<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    public function orderPrices(Request $request, $order_id)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $prices = Price::where('order_id', $order_id)->get();
        $res["success"] = true;
        if (count($prices) > 0){
            $res["data"] = $prices;
            $res["message"] = "Data retrieved!";
        } else {
            $res["message"] = "No Data to show!";
        }

        return response($res, $statusCode);
    }

    public function orderPricesCreate(Request $request, $order_id)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $this->validate($request, [
            "type"=>"required",
            "price"=>"required"
        ], 
        [
            "required"=>"Please fill this field :attribute"
        ]);

        try {
            $save = Price::create([
                "order_id"=>$order_id,
                "type"=>$request->input("type"),
                "price"=>$request->input("price")
            ]);
            $res["success"]=true;
            $res["message"]="Order price successfully added.";
            $res["data"]= $save;
        } catch (Exception $ex) {
            $statusCode=500;
            $res["message"]=$ex->getMessage();
        }

        return response($res, $statusCode);
    }

    public function orderPricesUpdate(Request $request, $order_id, $price_id)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        $data = ["order_id"=>$order_id];
        if($request->input("type")){
            $data["type"] = $request->input("type");
        }
        if($request->input("price")){
            $data["price"] = $request->input("price");
        }

        try {
            $price = Price::find($price_id);
            if($price){
                $price->update($data);
                $res["success"]=true;
                $res["message"]="Price successfully updated.";
                $res["data"]= $price;
            } else {
                $res["message"]="Could not find price.";
                $statusCode = 404;
            }
        } catch (Exception $ex) {
            $statusCode=500;
            $res["message"]=$ex->getMessage();
        }

        return response($res, $statusCode);
    }

    public function orderPricesDelete(Request $request, $order_id, $price_id)
    {
        $statusCode = 200;
        $res = ["success"=>false, "message"=>"", "data"=>null];

        try {
            $order = Price::find($price_id);
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