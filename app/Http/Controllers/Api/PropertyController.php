<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $items = Property::where('seller_id', $seller->id)->paginate(15);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $seller = $request->user()->seller;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'property_type' => 'required|string',
            'features' => 'nullable|array',
            'listing_type' => 'required|string',
            'rental_type' => 'nullable|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'size' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'other_features' => 'nullable|string',
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $data = $request->only(['title','property_type']);
        $data['features'] = $request->input('features') ? json_encode($request->input('features')) : null;
        $data = array_merge($data, $request->only(['listing_type','rental_type','price','address','city','zipcode','size','bedrooms','bathrooms','other_features']));
        $data['seller_id'] = $seller->id;
        $item = Property::create($data);
        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Property::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Property::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $data = $request->only(['title','property_type']);
        if ($request->has('features')) $data['features'] = json_encode($request->input('features'));
        $data = array_merge($data, $request->only(['listing_type','rental_type','price','address','city','zipcode','size','bedrooms','bathrooms','other_features']));
        $item->update($data);
        return response()->json(['success' => true, 'data' => $item->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Property::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $item->delete();
        return response()->json(['success' => true]);
    }
}
