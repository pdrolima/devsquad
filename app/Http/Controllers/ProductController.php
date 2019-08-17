<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Response;
use Facades\App\Services\ImageUpload;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        return ProductResource::collection($products);
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
            'image' => ! is_null($request->image) ? ImageUpload::upload($request->file('image')) : null,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
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
                'image' => ! is_null($request->file('image')) ? ImageUpload::upload($request->file('image')) : $instance->image,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price
            ]);
        })->save();

        return new ProductResource($product);
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

        return response()->json([], Response::HTTP_OK);
    }
}
