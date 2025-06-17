<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\ProductUpdatedEvent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Products;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Products::all();

        return response()->json([
            'success' => true,
            'data' => $products,
            'count' => $products->count()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:100'
        ]);

        $product = Products::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $product = Products::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock_quantity' => 'sometimes|integer|min:0',
            'category' => 'sometimes|string|max:100'
        ]);

        $product->update($validatedData);

        $event = new ProductUpdatedEvent();
        $event->publish([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    public function show($id): JsonResponse
    {
        $product = Products::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function test(): JsonResponse
    {
        return response()->json([
            'service' => 'products',
            'status' => 'running',
            'message' => 'Products API is operational',
            'timestamp' => now()->toISOString()
        ]);
    }
}
