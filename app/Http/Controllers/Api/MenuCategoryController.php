<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Services\FileService;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::with('categoryImage')->get(['id','name','image']);
        
        $categories = $categories->map(function ($category) {
            return [
                'id'=>$category->id,
                'name'=>$category->name,
                'image'=>$category->categoryImage?$category->categoryImage->image_url:null
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show($id)
    {
        $category = MenuCategory::with('categoryImage')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id'=>$category->id,
                'name'=>$category->name,
                'image'=>$category->categoryImage?$category->categoryImage->image_url:null
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'status'      => 'boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        $fileId = null;
        if ($request->hasFile('image')) {
            $fileId = (new FileService())->handleFileUpload($request->file('image'));
        }

        $category = MenuCategory::create([
            'name'        => $request->name,
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
        $category = MenuCategory::findOrFail($id);

        $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'status'      => 'boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        $fileId = $category->image;
        if ($request->hasFile('image')) {
            $fileId = (new FileService())->handleFileUpload($request->file('image'));
        }

        $category->update([
            'name'        => $request->name ?? $category->name,
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
        $category = MenuCategory::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

}
