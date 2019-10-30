<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

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
     * Oct. 29, 2019
     * @author john kevin paunel
     * this will add the item to cart session
     * @param Request $request
     * @return mixed
     * */
    public function addToCart(Request $request)
    {
        $item = Product::find($request->product);
        $request->validate([
            'quantity'      => ['required','numeric','min:1','max:'.$item->quantity],
        ]);


        Cart::add($item, $request->quantity, [])->associate(Product::class);

        return back()->with(['success' => true]);
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
