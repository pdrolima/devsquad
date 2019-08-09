<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Response;
use Facades\App\Services\ImageUpload;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(10);

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'image' => $request->has('image') ? ImageUpload::upload($request->image) : null,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
        ]);

        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        tap($product, function ($instance) use ($request) {
            return $instance->fill([
                'name' => $request->name,
                'image' => $request->has('image') ? ImageUpload::upload($request->image) : $instance->image,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price
            ]);
        })->save();

        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json($product, Response::HTTP_OK);
    }
}
