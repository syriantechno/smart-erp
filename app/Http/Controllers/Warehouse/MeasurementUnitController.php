<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\MeasurementUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MeasurementUnitController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:measurement_units,code',
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:25',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $unit = MeasurementUnit::create([
                'code' => $request->code,
                'name' => $request->name,
                'symbol' => $request->symbol,
                'is_active' => $request->boolean('is_active', true),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Unit created successfully'),
                'unit' => $unit,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('Failed to create unit: :message', ['message' => $e->getMessage()]),
            ], 500);
        }
    }
}
