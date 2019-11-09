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
            'image'         => ['required','image:jpeg,png','max:2048'],
            'title'         => ['required'],
            'price'         => ['required','numeric'],
            'category'      => ['required'],
            'description'   => ['required'],
            'sku'           => ['required'],
            'quantity'      => ['required','numeric'],
        ]);

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        $product = new Product();
        $product->title = $request->title;
        $product->size = $request->size.' '.$request->measurement;
        $product->weight = 0;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->created_by = auth()->user()->id;
        $product->productImage = $imageName;
        $product->sku = $request->sku;
        $product->quantity = $request->quantity;

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

    /**
     * Oct. 23, 2019
     * @author john kevin paunel
     * Update the product details
     * @param Request $request
     * @return mixed
     * */
    public function updateProduct(Request $request)
    {
        $request->validate([
            'title'         => ['required'],
            'price'         => ['required','numeric'],
            'category'      => ['required'],
            'description'   => ['required'],
            'sku'           => ['required'],
            'quantity'      => ['required','numeric'],
        ]);

        $product = Product::find($request->productId);
        $product->title = $request->title;
        $product->size = $request->size.' '.$request->measurement;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->sku = $request->sku;
        $product->quantity = $request->quantity;

        if($product->save())
        {
            $result = back()->with('success',true);
        }else{
            $result = back()->with('success',false);
        }

        return $result;
    }

    /**
     * Oct. 24, 2019
     * @author john kevin paunel
     * this will get all the product details
     * @param Request $request
     * @return array
     * */
    public function singleProductDetail(Request $request)
    {
        $details = "";
        $productDetail = explode("quick-view-", $request->id);
        foreach ($productDetail as $detail)
        {
            $details = $detail;
        }

        $productData = Product::find($details);
        $category = category::find($productData->category_id);

        $data = [
            'productId'       => $productData->id,
            'title'           => ucfirst($productData->title),
            'size'            => $productData->size,
            'description'     => $productData->description,
            'price'           => $productData->price,
            'image'           => asset('/images/'.$productData->productImage),
            'quantity'        => $productData->quantity,
            'category'        => $category->name,
            'permalink'       => $category->permalink,
            'permalinkUrl'    => route('customer.single',['category' => $category->permalink]),
        ];
        return $data;
    }

    public function category()
    {
        return view('pages.product.category');
    }
}
