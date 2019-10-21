<?php

namespace App\Http\Controllers;

use App\category;
use App\Product;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        return view('pages.product.products')->with([
            'products'      => Product::all(),
            'user'          => new ProductController(),
            'category'      => new ProductController(),
            'currentUser'   => auth()->user(),
        ]);
    }

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * get the object data of user creator of product
     * @param int $productId
     * @return object
     * */
    public function getAuthor($productId)
    {
        return Product::find($productId)->users;
    }

    /**
     * Oct. 20, 2019
     * @author john kevin paunel
     * get the product category object
     * @param int $categoryId
     * @return object
     * */
    public function getCategory($categoryId)
    {
        return category::find($categoryId);
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

    /**
     * Oct. 20, 2019
     * @author john kevin paunel
     * Create product
     * @param Request $request
     * @return mixed
     * */
    public function createProduct(Request $request)
    {
        $request->validate([
            'image'     => ['required','image:jpeg,png','max:2048'],
            'title'     => ['required'],
            'price'     => ['required','numeric','between:0,99.99'],
            'category'  => ['required'],
        ]);

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        $product = new Product();
        $product->title = $request->title;
        $product->size = $request->size.' '.$request->measurement;
        $product->description = $request->description;
        $product->price = $request->price;
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

    /**
     * Oct. 21, 2019
     * @author john kevin paunel
     * @param int $productId
     * @return mixed
     * */
    public function editProduct($productId)
    {
        return view('pages.product.editProduct')->with([
            'product'   => Product::find($productId),
            'categories' => category::all()
        ]);
    }
}
