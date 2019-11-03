<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
//use Gloudemans\Shoppingcart\Facades\Cart;

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

    }

    /**
     * Nov. 03, 2019
     * @author john kevin paunel
     * this will add or update the item quantity to cart /product_user table
     * @param Request $request
     * @return mixed
     * */
    public function addToCart(Request $request)
    {
        /**
         * fetch the product ID
         * @var $productId
         * */
        $productId = explode("product-",$request->value);

        /**
         * check if product exist or not to determine if it will insert new product or update product quantity
         * @var $checkIfExist
         * */
        $checkIfExist = Cart::where([
            ["user_id","=",auth()->user()->id],
            ["product_id","=",$productId[1]],
        ])->count();

            /**
             * retrieve the previous product quantity before updating it
             * @var $oldCart
             * @var $quantity
             * */
            if($checkIfExist > 0)
            {
                $oldCart = Cart::where([
                    ['user_id','=',auth()->user()->id],
                    ['product_id','=',$productId[1]],
                ])->first();
                $quantity = $oldCart->quantity;
                $id = $oldCart->id;
            }

            /**
             * this will save or update the product data to the product_user table
             * @var $cart
             * */
            $cart = ($checkIfExist > 0) ? Cart::find($id) : new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $productId[1];
            $cart->quantity = ($checkIfExist > 0) ? $quantity+1 : 1;
            $cart->status = "pending";


        if($cart->save()){
            $message = ["success" => true];
        }else{
            $message = ["success" => false];
        }

        return response()->json($message);
    }

    /**
     * Oct. 29, 2019
     * @author john kevin paunel
     * remove item from cart
     * @param int $rowId
     * @return mixed
     * */
    public function removeItemFromCart($rowId)
    {
        Cart::remove($rowId);

        return back();
    }

    /**
     * Oct. 30, 2019
     * @author john kevin paunel
     * update item quantity from cart
     * @param Request $request
     * @return mixed
     * */
    public function updateCart(Request $request)
    {
        $rowId = explode('update-',$request->id)[1];

        #item stock quantity
        $quantity = Cart::get($rowId)->model->quantity;

        if($request->qty <= $quantity)
        {
            Cart::update($rowId,$request->qty);
            $message = ['success' => true];
        }else{
            $message = ['success' => false];
        }


        return response()->json($message);
    }
}
