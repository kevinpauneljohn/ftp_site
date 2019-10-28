<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Oct. 28, 2019
     * @author john kevin paunel
     * save order from customers
     * @param Request $request
     * @return mixed
     * */
    public function saveOrders(Request $request)
    {
        /**
         * retrieve the user id of the current user logged in
         * @var $userId
         * */
        $userId = auth()->user()->id;

        /**
         * this will check if there are existing orders in the database
         * @var $checkIfThereIsOrder
         * */
        $checkIfThereIsOrder = Order::where([
            ["user_id","=",$userId],
            ["status","=","pending"],
        ])->count();


        if($checkIfThereIsOrder < 1)
        {
            $order = new Order();

            $order->user_id = $userId;
            $order->orders = array($request->product => [
                "product_id" => $request->product,
                "quantity"   => $request->quantity
            ]);
            $order->status = "pending";

            if($order->save())
            {
                $result = back()->with('success',true);
            }else{
                $result = back()->with('success',false);
            }

        }else{
            /**
             * update the orders if exist
             * @var $order
             * */
            $order = DB::table('orders')
                ->where([
                    ['user_id','=',$userId],
                    ['status','=','pending'],
                ])->update(['orders->'.$request->product.'->quantity' => $request->quantity]);
            $result = back()->with('success',true);
        }

        return $result;

    }
}
