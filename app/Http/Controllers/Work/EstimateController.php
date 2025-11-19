<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('work.estimates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work.estimates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implement estimate creation
        return redirect()->route('work.estimates.index')->with('success', 'Estimate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('work.estimates.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('work.estimates.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement estimate update
        return redirect()->route('work.estimates.index')->with('success', 'Estimate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implement estimate deletion
        return response()->json(['success' => true, 'message' => 'Estimate deleted successfully.']);
    }

    /**
     * Get estimates data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        // TODO: Implement DataTables response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => []
        ]);
    }

    /**
     * Preview estimate code
     */
    public function previewCode(): JsonResponse
    {
        // TODO: Generate estimate code
        $code = 'EST-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return response()->json(['code' => $code]);
    }
}
