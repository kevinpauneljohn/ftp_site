<?php

namespace App\Http\Controllers;

use App\category;
use App\Product;
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
     *Oct. 20, 2019
     * @author john kevin paunel
     * Add product view
     * @return mixed
     * */
    public function addProduct()
    {
        return view('pages.product.addProduct')->with([
            'categories' => category::all()
        ]);
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'image'     => ['required','image:jpeg,png','max:2048'],
            'title'     => ['required'],
            'category'  => ['required'],
        ]);

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        $product = new Product();
        $product->title = $request->title;
        $product->size = $request->size.' '.$request->measurement;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->created_by = auth()->user()->id;
        $product->productImage = $imageName;

        if($product->save())
        {
            request()->image->move(public_path('images'), $imageName);
            $result = back()->with('success',true);
        }else{
            $result = back()->with('success',false);
        }

        return $result;
    }
}
