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
     * @param int $productId
     * @return int
     * */
    public function checkProductQuantity($productId)
    {
        return Product::find($productId)->quantity;
    }

    /**
     * Nov. 03, 2019
     * @author john kevin paunel
     * Url: /add-to-cart
     * Route Name: orders.cart
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
         * db table: product_user_table
         * @var $checkIfExist
         * */
        $checkIfExist = Cart::where([
            ["user_id","=",auth()->user()->id],
            ["product_id","=",$productId[1]],
        ])->count();

            if($checkIfExist > 0)
            {
                /**
                 * retrieve the previous product quantity before updating it
                 * @var $oldCart
                 * @var $quantity
                 * */
                $oldCart = Cart::where([
                    ['user_id','=',auth()->user()->id],
                    ['product_id','=',$productId[1]],
                ])->first();
                $quantity = $oldCart->quantity;

                /**
                 * this will get the product_user table id to be use in retrieving cart
                 * @var $id
                 * */
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


            /**
             * this will get the total quantity of ordered items to be compared in the current product stock
             * @var $quantity
             * */
            $quantity = ($checkIfExist > 0) ? $quantity + 1 : 1;

            #conditional statement for comparing ordered quantity to the current product quantity
            if( $quantity <= $this->checkProductQuantity($productId[1]))
            {
                if($cart->save()){
                    $message = ["success" => true, "quantity" => Cart::where('user_id',auth()->user()->id)->count()];
                }else{
                    $message = ["success" => false];
                }
            }else{
                $message = ["success" => false, "message" => "quantity must not be greater than the available stock!"];
            }

            /**
             * this response will be retrieved by addToCart.js
             * */
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

        #item stock quantity from product_user table
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

    /**
     * @author john kevin paunel
     * Nov. 04, 2019
     * get the sum of the specific product
     * @param int $productId
     * @return int
     * */
    public function getProductTotalAmount($productId)
    {
        /**
         * product price
         * @var $productPrice
         * */
        $productPrice = Product::find($productId)->price;
        /**
         * item quantity inside the cart
         * @var $itemQty
         * */
        $itemQty = Cart::where([
            ["user_id","=",auth()->user()->id],
            ["product_id","=",$productId],
        ])->first();
        /**
         * total amount of the item inside the cart
         * @var $amount
         * */
        $amount = $itemQty->quantity * $productPrice;

        return $amount;
    }
}
