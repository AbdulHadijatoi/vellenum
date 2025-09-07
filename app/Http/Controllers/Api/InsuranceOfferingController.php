<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InsuranceOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InsuranceOfferingController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $items = InsuranceOffering::where('seller_id', $seller->id)->paginate(15);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $seller = $request->user()->seller;
        $validator = Validator::make($request->all(), [
            'insurance_name' => 'required|string|max:255',
            'insurance_type' => 'required|string|max:255',
            'rate_basic' => 'nullable|numeric',
            'rate_standard' => 'nullable|numeric',
            'rate_premium' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        $data = $request->only(['insurance_name','insurance_type','rate_basic','rate_standard','rate_premium','description']);
        $data['seller_id'] = $seller->id;
        $item = InsuranceOffering::create($data);
        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = InsuranceOffering::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = InsuranceOffering::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $data = $request->only(['insurance_name','insurance_type','rate_basic','rate_standard','rate_premium','description']);
        $item->update($data);
        return response()->json(['success' => true, 'data' => $item->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = InsuranceOffering::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $item->delete();
        return response()->json(['success' => true]);
    }
}
