<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SellerMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerMenuController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $items = SellerMenu::where('seller_id', $seller->id)->paginate(15);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $seller = $request->user()->seller;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'nullable|string',
            'discount' => 'nullable|string',
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        $data = $request->only(['name','category','description','price','duration','discount']);
        $data['seller_id'] = $seller->id;
        $item = SellerMenu::create($data);
        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = SellerMenu::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = SellerMenu::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $data = $request->only(['name','category','description','price','duration','discount']);
        $item->update($data);
        return response()->json(['success' => true, 'data' => $item->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = SellerMenu::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $item->delete();
        return response()->json(['success' => true]);
    }
}
