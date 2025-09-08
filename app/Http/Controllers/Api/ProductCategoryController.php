<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('categoryImage')->get();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show($id)
    {
        $category = ProductCategory::with('categoryImage')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:product_categories,slug',
            'description' => 'nullable|string',
            'status'      => 'boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        $fileId = null;
        if ($request->hasFile('image')) {
            $fileId = (new FileService())->handleFileUpload($request->file('image'));
        }

        $category = ProductCategory::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->slug),
            'description' => $request->description,
            'status'      => $request->status ?? 1,
            'image'       => $fileId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'slug'        => 'sometimes|required|string|max:255|unique:product_categories,slug,' . $id,
            'description' => 'nullable|string',
            'status'      => 'boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        $fileId = $category->image;
        if ($request->hasFile('image')) {
            $fileId = (new FileService())->handleFileUpload($request->file('image'));
        }

        $category->update([
            'name'        => $request->name ?? $category->name,
            'slug'        => $request->slug ? Str::slug($request->slug) : $category->slug,
            'description' => $request->description ?? $category->description,
            'status'      => $request->status ?? $category->status,
            'image'       => $fileId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

}
