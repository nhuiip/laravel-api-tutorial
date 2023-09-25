<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(null, Product::with('category_mappings.category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'sku' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors(), 400);
        }

        $product = Product::create($request->all());
        return $this->successResponse('Product created successfully', $product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category_mappings.category')->where('id', $id)->first();

        if (!$product) {
            return $this->errorResponse('Product not found', null, 404);
        }

        return $this->successResponse(null, $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(request()->all(), [
            'sku' => 'required|unique:products,sku,' . $id,
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors(), 400);
        }

        $product = Product::findOrFail($id);
        $product->update($request->all());
        return $this->successResponse('Product updated successfully', $product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->successResponse('Product deleted successfully', null, 200);
    }
}
