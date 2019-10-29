<?php

namespace App\Http\Controllers;

use App\Order;
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
            'quantity'      => ['required','numeric','max:'.$item->quantity],
        ]);


        Cart::add($item, $request->quantity, [])->associate(Product::class);

        return back()->with(['success' => true]);
    }
}
