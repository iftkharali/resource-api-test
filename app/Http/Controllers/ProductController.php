<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all()->toArray();
        return response()->json(['msg' => 'here is data', 'data' => $products]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // as we are creating api so we do not need this method, these methods are created automaticaly with command we can delete these
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
         // I did not added the redirection to show validation error, i need to check it if we need it, it would through the proper errors, 
         // while any of the validation is missing. let's leave it for now, it is redirecting on the homepage. okay so finaly it worked

        // it was giving the fillable error for mass insertion, so added variables as fillable for db columns

            Product::create(['name' => $request->name, 'description' => $request->description, 'price' => $request->price ]);
            return response()->json(['msg' => 'data is added successfuly', 'status' => 200 ]);

    }

    /**
     * Display the specified resource.
     *  i am deleting resource as it is used for big projects, when we have alot of data.
     */
    public function show($id)
    {
        $product = Product::find($id)->toArray();
        return response()->json(['msg' => 'here is data', 'data' => $product]);
    
    }

    /**
     * Show the form for editing the specified resource.
     * again we do not have the web, so we do not need this method to show page somewhere on route 
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        // as we are not giving any data via postman. so errors are apearing now, even we do not need the extra parameter, we need id, I was thinking that
        // we have the prodcut resource, so we do not need require the id parameter, but we require it here. so added, we will need either 
        // product resource or product id for updating as second parameterd
        // now i am getting the updated data in the request.

        $prodcut = Product::where('id', $id)->update(['name' => $request->name, 'price' => $request->price]);
        if(!$prodcut){
            return response()->json(['error' => 'no product found', 'status' => 401]);
        }
        return response()->json(['success' => 'product updated successfully', 'status' => 200]);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['error' => 'no product found', 'status' => 401]);
        }
        $product->delete();
        return response()->json(['success' => 'product deleted successfully', 'status' => 200]);
    }
}
