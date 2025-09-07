<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $items = Vehicle::where('seller_id', $seller->id)->with(['photos'])->paginate(15);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $seller = $request->user()->seller;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|digits:4|integer',
            'mileage' => 'nullable|integer',
            'hourly_rate' => 'required|numeric',
            'license_number' => 'nullable|string',
            'registration_date' => 'nullable|date',
            'registration_document' => 'nullable|exists:files,id',
            'insurance_document' => 'nullable|exists:files,id',
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);

        $data = $request->only(['name','make','model','year','mileage','hourly_rate','license_number','registration_date','registration_document','insurance_document']);
        $data['seller_id'] = $seller->id;
        $item = Vehicle::create($data);
        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Vehicle::where('id', $id)->where('seller_id', $seller->id)->with(['photos'])->firstOrFail();
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Vehicle::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $data = $request->only(['name','make','model','year','mileage','hourly_rate','license_number','registration_date','registration_document','insurance_document']);
        $item->update($data);
        return response()->json(['success' => true, 'data' => $item->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $item = Vehicle::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $item->delete();
        return response()->json(['success' => true]);
    }
}
