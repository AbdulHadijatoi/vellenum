<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuImage;
use App\Models\SellerMenu;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerMenuController extends Controller
{
    public function index(Request $request)
    {
        // $seller = $request->user()->seller;
        $items = SellerMenu::with(['category','images', 'primaryImage'])
                    // ->where('seller_id', $seller->id)
                    ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'menu_category_id' => 'required|exists:menu_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'discount' => 'nullable|string',
            'seller_id' => 'nullable|exists:sellers,id',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $data = $request->only([
            'name',
            'menu_category_id',
            'description',
            'price',
            'duration',
            'discount',
            'seller_id'
        ]);

        // $data['seller_id'] = $seller->id;

        $item = SellerMenu::create($data);

         // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $fileId = (new FileService())->handleFileUpload($image);

                // Create product image relationship
                MenuImage::create([
                    'seller_menu_id' => $item->id,
                    'file_id' => $fileId,
                    'sort_order' => $index,
                    'is_primary' => $index == 0,
                ]);
            }
        }

        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(Request $request, $id)
    {
        $item = SellerMenu::with(['category','images', 'primaryImage'])->where('id', $id)->firstOrFail();
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'category' => 'nullable|string',
            'description' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'discount' => 'nullable',
            'delete_image_ids' => 'nullable|array',
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

        $item = SellerMenu::where('id', $id)
                        ->firstOrFail();

        $data = $request->only([
            'name',
            'category',
            'description',
            'price',
            'duration',
            'discount'
        ]);

        $item->update($data);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old product images
            $item->images()->delete();

            foreach ($request->file('images') as $index => $image) {
                $fileId = (new FileService())->handleFileUpload($image);

                // Create item image relationship
                MenuImage::create([
                    'seller_menu_id' => $item->id,
                    'file_id' => $fileId,
                    'sort_order' => $index,
                    'is_primary' => $index === 0 && !$request->has('image_file_id'),
                ]);
            }
        }

        if(count($request->delete_image_ids)){
            $productImages = MenuImage::whereIn('id', $request->delete_image_ids)->get();

            if($productImages->count()>0){
                foreach ($productImages as $productImage) {
                    $productImage->deleteWithFile();
                }
            }
        }

        return response()->json(['success' => true, 'data' => $item->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $item = SellerMenu::where('id', $id)
                    ->firstOrFail();
        $item->delete();
        return response()->json(['success' => true]);
    }
}
