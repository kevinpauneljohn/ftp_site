<?php

namespace App\Http\Controllers\customer;

use App\category;
use App\Http\Controllers\Controller;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Oct. 23, 2019
     * @author john kevin paunel
     * index page of website
     * @return mixed
     * */
    public function index()
    {
        return view('customer.index');
    }

    /**
     * Oct. 23, 2019
     * @author john kevin paunel
     * @param string $permalink
     * @return mixed
     * */
    public function singleCategory($permalink)
    {
        /**
         * @var $category
         * this will get the id needed for products category
         * */
        $category = category::where('permalink',$permalink)->first();

        $products = Product::where('category_id',$category->id)->get();
        return view('customer.single_category')->with([
            'products'      => $products,
        ]);
    }

    /**
     * Oct. 28, 2019
     * @author john kevin paunel
     * display of single product details
     * @param int $category
     * @param int $id
     * @return mixed
     * */
    public function singleProductDetails($category, $id)
    {
        $product = Product::find($id);
        return view('customer.productDetail')->with([
            'product'               => $product,
            'allProduct'            => Product::all(),
            'category'              => category::find($product->category_id),
            'productId'             => $id
        ]);
    }

    /**
     * Oct. 29, 2019
     * @author john kevin paunel
     * view cart page
     * @return mixed
     * */
    public function getCart()
    {
        return view('customer.cart');
    }

}
