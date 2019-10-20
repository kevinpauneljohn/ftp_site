<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Oct. 20, 2019
     * @author john kevin paunel
     * Product View Page
     * @return mixed
     * */
    public function products()
    {
        return view('pages.product.products');
    }

    /**
     *
     * */
    public function addProduct()
    {
        return view('pages.product.addProduct');
    }
}
