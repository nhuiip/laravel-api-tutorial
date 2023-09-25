<?php

namespace App\Http\Controllers\Api;

use App\Models\CategoryMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryMappingController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors(), 400);
        }

        if (CategoryMapping::where('category_id', $request->category_id)->where('product_id', $request->product_id)->exists()) {
            return $this->errorResponse('Category mapping already exists', [], 400);
        }

        $categoryMapping = CategoryMapping::create($request->all());
        $data = CategoryMapping::with('category')->with('product')->where('id', $categoryMapping->id)->first();

        return $this->successResponse('Category mapped successfully', $data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryMapping = CategoryMapping::findOrFail($id);
        $categoryMapping->delete();

        return $this->successResponse('Product deleted successfully', null, 200);
    }
}
