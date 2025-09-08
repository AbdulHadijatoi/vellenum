<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    public function createProduct(Request $request)
    {
        // $user = $request->user();
        // $seller = $user->seller;

        // if (!$seller) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Seller profile not found'
        //     ], 404);
        // }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'type' => 'required|in:product,service',
            // 'attributes' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'product_category_id' => $request->product_category_id,
            'type' => $request->type,
            'seller_id' => $request->seller_id
        ]);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $fileId = (new FileService())->handleFileUpload($image);

                // Create product image relationship
                ProductImage::create([
                    'product_id' => $product->id,
                    'file_id' => $fileId,
                    'sort_order' => $index,
                    'is_primary' => $index == 0,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        // $user = $request->user();
        // $seller = $user->seller;

        // if (!$seller) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Seller profile not found'
        //     ], 404);
        // }

        $product = Product::where('id', $id)
                        // ->where('seller_id', $seller->id)
                        ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'type' => 'sometimes|in:product,service',
            'attributes' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $productData = $request->only([
            'title', 'description', 'price', 'quantity', 'product_category_id', 
            'type', 'attributes', 'status', 'is_featured'
        ]);

        $product->update($productData);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old product images
            $product->images()->delete();

            foreach ($request->file('images') as $index => $image) {
                $fileId = (new FileService())->handleFileUpload($image);

                // Create product image relationship
                ProductImage::create([
                    'product_id' => $product->id,
                    'file_id' => $fileId,
                    'sort_order' => $index,
                    'is_primary' => $index === 0 && !$request->has('image_file_id'),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->fresh()
        ]);
    }

    public function getProduct(Request $request, $id)
    {
        // $user = $request->user();
        // $seller = $user->seller;

        // if (!$seller) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Seller profile not found'
        //     ], 404);
        // }

        $product = Product::where('id', $id)
            // ->where('seller_id', $seller->id)
            ->with(['productCategory', 'primaryImage.file', 'images.file'])
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function getProducts(Request $request)
    {
        $user = $request->user();
        // $seller = $user->seller;
        // if (!$seller) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Seller profile not found'
        //     ], 404);
        // }

        $products = Product::with(['productCategory', 'primaryImage', 'images'])
            // ->where('seller_id', $seller->id)
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function deleteProduct($id)
    {
        // $user = auth()->user();
        // $seller = $user->seller;

        // if (!$seller) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Seller profile not found'
        //     ], 404);
        // }

        $product = Product::where('id', $id)
                    // ->where('seller_id', $seller->id)
                    ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Delete associated files
        if ($product->imageFile) {
            $product->imageFile->deleteFromDisk();
            $product->imageFile->delete();
        }

        // Delete product images and their files
        foreach ($product->images as $productImage) {
            $productImage->file->deleteFromDisk();
            $productImage->file->delete();
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}