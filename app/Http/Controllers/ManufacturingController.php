<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use App\Models\ProductionMachine;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManufacturingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Get manufacturing statistics
        $stats = [
            'total_orders' => ProductionOrder::count(),
            'in_progress' => ProductionOrder::where('status', 'in_progress')->count(),
            'completed' => ProductionOrder::where('status', 'completed')->count(),
            'active_machines' => ProductionMachine::where('status', 'active')->count(),
        ];

        // Get recent production orders
        $recentOrders = ProductionOrder::latest()->take(5)->get();

        return view('manufacturing.index', compact('stats', 'recentOrders'));
    }

    // Production Orders Management
    public function ordersIndex()
    {
        $orders = ProductionOrder::with('createdBy', 'approvedBy')->paginate(15);
        return view('manufacturing.orders.index', compact('orders'));
    }

    public function createOrder()
    {
        return view('manufacturing.orders.create');
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        $validated['order_number'] = 'PO-' . date('Y') . '-' . str_pad(ProductionOrder::count() + 1, 4, '0', STR_PAD_LEFT);
        $validated['created_by'] = auth()->id();
        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];

        ProductionOrder::create($validated);

        return redirect()->route('manufacturing.orders.index')->with('success', 'Production order created successfully');
    }

    public function showOrder(ProductionOrder $order)
    {
        $order->load('details.stage', 'materials', 'qualityChecks');
        return view('manufacturing.orders.show', compact('order'));
    }

    public function editOrder(ProductionOrder $order)
    {
        return view('manufacturing.orders.edit', compact('order'));
    }

    public function updateOrder(Request $request, ProductionOrder $order)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:draft,confirmed,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];

        $order->update($validated);

        return redirect()->route('manufacturing.orders.index')->with('success', 'Production order updated successfully');
    }

    public function destroyOrder(ProductionOrder $order)
    {
        $order->delete();
        return redirect()->route('manufacturing.orders.index')->with('success', 'Production order deleted successfully');
    }

    // Production Stages Management
    public function stagesIndex()
    {
        $stages = \App\Models\ProductionStage::orderBy('sequence')->get();
        return view('manufacturing.stages.index', compact('stages'));
    }

    public function storeStage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_hours' => 'required|integer|min:1',
            'stage_cost' => 'required|numeric|min:0',
        ]);

        $maxSequence = \App\Models\ProductionStage::max('sequence') ?? 0;
        $validated['sequence'] = $maxSequence + 1;

        \App\Models\ProductionStage::create($validated);

        return redirect()->route('manufacturing.stages.index')->with('success', 'Production stage created successfully');
    }

    public function updateStage(Request $request, $stageId)
    {
        $stage = \App\Models\ProductionStage::findOrFail($stageId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_hours' => 'required|integer|min:1',
            'stage_cost' => 'required|numeric|min:0',
            'sequence' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $stage->update($validated);

        return redirect()->route('manufacturing.stages.index')->with('success', 'Production stage updated successfully');
    }

    public function destroyStage($stageId)
    {
        $stage = \App\Models\ProductionStage::findOrFail($stageId);
        $stage->delete();

        return redirect()->route('manufacturing.stages.index')->with('success', 'Production stage deleted successfully');
    }

    // Machines Management
    public function machinesIndex()
    {
        $machines = ProductionMachine::paginate(15);
        return view('manufacturing.machines.index', compact('machines'));
    }

    public function storeMachine(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:production_machines,code',
            'model' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:manual,semi_automatic,automatic,cnc',
            'hourly_rate' => 'required|numeric|min:0',
            'capacity_per_hour' => 'required|integer|min:1',
            'specifications' => 'nullable|json',
            'purchase_date' => 'nullable|date',
        ]);

        ProductionMachine::create($validated);

        return redirect()->route('manufacturing.machines.index')->with('success', 'Machine added successfully');
    }

    public function updateMachine(Request $request, ProductionMachine $machine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:production_machines,code,' . $machine->id,
            'model' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:manual,semi_automatic,automatic,cnc',
            'status' => 'required|in:active,maintenance,out_of_order,retired',
            'hourly_rate' => 'required|numeric|min:0',
            'capacity_per_hour' => 'required|integer|min:1',
            'specifications' => 'nullable|json',
            'purchase_date' => 'nullable|date',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date',
        ]);

        $machine->update($validated);

        return redirect()->route('manufacturing.machines.index')->with('success', 'Machine updated successfully');
    }

    public function destroyMachine(ProductionMachine $machine)
    {
        $machine->delete();
        return redirect()->route('manufacturing.machines.index')->with('success', 'Machine deleted successfully');
    }

    // Quality Control
    public function qualityIndex()
    {
        $checks = \App\Models\QualityCheck::with('productionOrder', 'checkedBy')->paginate(15);
        return view('manufacturing.quality.index', compact('checks'));
    }

    public function storeQualityCheck(Request $request)
    {
        $validated = $request->validate([
            'production_order_id' => 'required|exists:production_orders,id',
            'check_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'check_type' => 'required|in:incoming,in_process,final,random',
            'status' => 'required|in:pending,passed,failed,rework_required',
            'sample_size' => 'nullable|integer|min:1',
            'defect_count' => 'required|integer|min:0',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'measurements' => 'nullable|json',
        ]);

        $validated['checked_by'] = auth()->id();
        $validated['checked_at'] = now();

        \App\Models\QualityCheck::create($validated);

        return redirect()->route('manufacturing.quality.index')->with('success', 'Quality check recorded successfully');
    }

    public function updateQualityCheck(Request $request, $checkId)
    {
        $check = \App\Models\QualityCheck::findOrFail($checkId);

        $validated = $request->validate([
            'check_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'check_type' => 'required|in:incoming,in_process,final,random',
            'status' => 'required|in:pending,passed,failed,rework_required',
            'sample_size' => 'nullable|integer|min:1',
            'defect_count' => 'required|integer|min:0',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'measurements' => 'nullable|json',
        ]);

        $check->update($validated);

        return redirect()->route('manufacturing.quality.index')->with('success', 'Quality check updated successfully');
    }

    // Reports
    public function reportsIndex()
    {
        $reports = \App\Models\ProductionReport::paginate(15);
        return view('manufacturing.reports.index', compact('reports'));
    }

    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:daily,weekly,monthly,custom',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Generate report logic here
        $reportData = [
            'report_number' => 'RPT-' . date('Ymd') . '-' . time(),
            'report_type' => $validated['report_type'],
            'report_date' => now(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_orders' => ProductionOrder::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])->count(),
            'completed_orders' => ProductionOrder::where('status', 'completed')->whereBetween('updated_at', [$validated['start_date'], $validated['end_date']])->count(),
            'generated_by' => auth()->id(),
        ];

        \App\Models\ProductionReport::create($reportData);

        return redirect()->route('manufacturing.reports.index')->with('success', 'Report generated successfully');
    }

    // API Methods for AJAX
    public function ordersDatatable()
    {
        $orders = ProductionOrder::with('createdBy')->select('production_orders.*');

        return datatables()->of($orders)
            ->addColumn('status_badge', function($order) {
                $colors = [
                    'draft' => 'gray',
                    'confirmed' => 'blue',
                    'in_progress' => 'yellow',
                    'completed' => 'green',
                    'cancelled' => 'red'
                ];
                $color = $colors[$order->status] ?? 'gray';
                return '<span class="px-2 py-1 text-xs rounded-full bg-' . $color . '-100 text-' . $color . '-800">' . ucfirst($order->status) . '</span>';
            })
            ->addColumn('actions', function($order) {
                return '
                    <a href="' . route('manufacturing.orders.show', $order) . '" class="text-blue-600 hover:text-blue-800 mr-2">View</a>
                    <a href="' . route('manufacturing.orders.edit', $order) . '" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                ';
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function getActiveStages()
    {
        return response()->json(\App\Models\ProductionStage::where('is_active', true)->orderBy('sequence')->get());
    }

    public function getAvailableMachines()
    {
        return response()->json(ProductionMachine::where('status', 'active')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturing $manufacturing)
    {
        return $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturing $manufacturing)
    {
        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturing $manufacturing)
    {
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturing $manufacturing)
    {
        return $this->index();
    }
}
