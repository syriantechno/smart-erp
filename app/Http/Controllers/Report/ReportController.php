<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\PaymentVoucher;
use App\Models\Accounting\ReceiptVoucher;
use App\Models\Customer;
use App\Models\HR\Advance;
use App\Models\HR\Attendance;
use App\Models\HR\Employee;
use App\Models\HR\Leave;
use App\Models\HR\Payroll;
use App\Models\HR\Penalty;
use App\Models\Supplier\Vendor;
use App\Models\Warehouse\Material;
use App\Models\Warehouse\PurchaseOrder;
use App\Models\Warehouse\SaleOrder;
use App\Models\Work\Project;
use App\Models\Work\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function index()
    {
        try {
            // Get summary statistics with safe defaults
            $stats = [
                'total_revenue' => $this->safeSum(Invoice::class, 'total', ['status' => 'paid']),
                'total_expenses' => $this->safeSum(PaymentVoucher::class, 'total_amount'),
                'total_receipts' => $this->safeSum(ReceiptVoucher::class, 'total_amount'),
                'total_employees' => $this->safeCount(Employee::class, ['is_active' => true]),
                'total_customers' => $this->safeCount(Customer::class),
                'total_vendors' => $this->safeCount(Vendor::class),
                'total_projects' => $this->safeCount(Project::class),
                'pending_tasks' => $this->safeCount(Task::class, ['status' => 'pending']),
            ];

            // Recent activity
            $recentInvoices = $this->safeQuery(Invoice::class, fn($q) => $q->with('customer')->latest()->take(5)->get());
            $recentPayments = $this->safeQuery(PaymentVoucher::class, fn($q) => $q->latest()->take(5)->get());
            $recentReceipts = $this->safeQuery(ReceiptVoucher::class, fn($q) => $q->latest()->take(5)->get());

            return view('reports.index', compact('stats', 'recentInvoices', 'recentPayments', 'recentReceipts'));
        } catch (\Exception $e) {
            \Log::error('Reports Dashboard Error: ' . $e->getMessage());
            return view('reports.index', [
                'stats' => array_fill_keys(['total_revenue', 'total_expenses', 'total_receipts', 'total_employees', 'total_customers', 'total_vendors', 'total_projects', 'pending_tasks'], 0),
                'recentInvoices' => collect(),
                'recentPayments' => collect(),
                'recentReceipts' => collect(),
            ]);
        }
    }

    /**
     * Safe sum helper
     */
    private function safeSum($model, $column, $where = [])
    {
        try {
            $query = $model::query();
            foreach ($where as $key => $value) {
                $query->where($key, $value);
            }
            return $query->sum($column) ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Safe count helper
     */
    private function safeCount($model, $where = [])
    {
        try {
            $query = $model::query();
            foreach ($where as $key => $value) {
                $query->where($key, $value);
            }
            return $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Safe query helper
     */
    private function safeQuery($model, $callback)
    {
        try {
            return $callback($model::query());
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Financial Reports
     */
    public function financial(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $reportType = $request->get('report_type', 'summary');

        // Revenue (Invoices)
        $revenue = Invoice::whereBetween('invoice_date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->sum('total') ?? 0;

        // Expenses (Payment Vouchers)
        $expenses = PaymentVoucher::whereBetween('voucher_date', [$startDate, $endDate])
            ->sum('total_amount') ?? 0;

        // Receipts
        $receipts = ReceiptVoucher::whereBetween('voucher_date', [$startDate, $endDate])
            ->sum('total_amount') ?? 0;

        // Net Profit
        $netProfit = $revenue - $expenses;

        // Monthly breakdown
        $monthlyData = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($start <= $end) {
            $monthStart = $start->copy()->startOfMonth();
            $monthEnd = $start->copy()->endOfMonth();

            $monthlyData[] = [
                'month' => $start->format('M Y'),
                'revenue' => Invoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
                    ->where('status', 'paid')->sum('total') ?? 0,
                'expenses' => PaymentVoucher::whereBetween('voucher_date', [$monthStart, $monthEnd])
                    ->sum('total_amount') ?? 0,
            ];

            $start->addMonth();
        }

        // Top customers by revenue
        $topCustomers = Invoice::select('customer_id', DB::raw('SUM(total) as total_revenue'))
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->groupBy('customer_id')
            ->orderByDesc('total_revenue')
            ->with('customer')
            ->take(10)
            ->get();

        // Expense categories
        $expensesByAccount = PaymentVoucher::select('account_id', DB::raw('SUM(total_amount) as total'))
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->groupBy('account_id')
            ->with('account')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return view('reports.financial', compact(
            'startDate', 'endDate', 'reportType',
            'revenue', 'expenses', 'receipts', 'netProfit',
            'monthlyData', 'topCustomers', 'expensesByAccount'
        ));
    }

    /**
     * HR Reports
     */
    public function hr(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $reportType = $request->get('report_type', 'summary');

        // Employee statistics
        $totalEmployees = Employee::where('is_active', true)->count();
        $newHires = Employee::whereBetween('hire_date', [$startDate, $endDate])->count();

        // Payroll summary
        $totalPayroll = Payroll::whereBetween('pay_date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->sum('net_salary') ?? 0;

        $payrollByDepartment = Payroll::select('employees.department_id', DB::raw('SUM(payrolls.net_salary) as total'))
            ->join('employees', 'payrolls.employee_id', '=', 'employees.id')
            ->whereBetween('payrolls.pay_date', [$startDate, $endDate])
            ->where('payrolls.status', 'paid')
            ->groupBy('employees.department_id')
            ->with('employee.department')
            ->get();

        // Attendance summary
        $attendanceStats = [
            'total_present' => Attendance::whereBetween('date', [$startDate, $endDate])
                ->where('status', 'present')->count(),
            'total_absent' => Attendance::whereBetween('date', [$startDate, $endDate])
                ->where('status', 'absent')->count(),
            'total_late' => Attendance::whereBetween('date', [$startDate, $endDate])
                ->where('is_late', true)->count(),
        ];

        // Leave summary
        $leaveStats = Leave::select('type', DB::raw('COUNT(*) as count'))
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'approved')
            ->groupBy('type')
            ->get();

        // Advances summary
        $totalAdvances = Advance::whereBetween('request_date', [$startDate, $endDate])
            ->where('status', 'disbursed')
            ->sum('amount') ?? 0;

        // Penalties summary
        $totalPenalties = Penalty::whereBetween('penalty_date', [$startDate, $endDate])
            ->where('status', 'applied')
            ->where('type', 'financial')
            ->sum('amount') ?? 0;

        // Employees by department
        $employeesByDepartment = Employee::select('department_id', DB::raw('COUNT(*) as count'))
            ->where('is_active', true)
            ->groupBy('department_id')
            ->with('department')
            ->get();

        return view('reports.hr', compact(
            'startDate', 'endDate', 'reportType',
            'totalEmployees', 'newHires', 'totalPayroll',
            'payrollByDepartment', 'attendanceStats', 'leaveStats',
            'totalAdvances', 'totalPenalties', 'employeesByDepartment'
        ));
    }

    /**
     * Inventory Reports
     */
    public function inventory(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Materials summary
        $totalMaterials = Material::where('is_active', true)->count();
        $lowStockMaterials = Material::where('is_active', true)
            ->whereColumn('quantity', '<=', 'minimum_quantity')
            ->count();

        // Inventory value
        $inventoryValue = Material::where('is_active', true)
            ->selectRaw('SUM(quantity * unit_price) as total_value')
            ->value('total_value') ?? 0;

        // Purchase orders summary
        $purchaseOrdersStats = [
            'total' => PurchaseOrder::whereBetween('order_date', [$startDate, $endDate])->count(),
            'total_value' => PurchaseOrder::whereBetween('order_date', [$startDate, $endDate])
                ->sum('total_amount') ?? 0,
            'pending' => PurchaseOrder::whereBetween('order_date', [$startDate, $endDate])
                ->where('status', 'pending')->count(),
            'completed' => PurchaseOrder::whereBetween('order_date', [$startDate, $endDate])
                ->where('status', 'completed')->count(),
        ];

        // Top materials by quantity
        $topMaterials = Material::where('is_active', true)
            ->orderByDesc('quantity')
            ->take(10)
            ->get();

        // Materials by category
        $materialsByCategory = Material::select('category_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(quantity * unit_price) as value'))
            ->where('is_active', true)
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Low stock alerts
        $lowStockAlerts = Material::where('is_active', true)
            ->whereColumn('quantity', '<=', 'minimum_quantity')
            ->with('category')
            ->take(20)
            ->get();

        return view('reports.inventory', compact(
            'startDate', 'endDate',
            'totalMaterials', 'lowStockMaterials', 'inventoryValue',
            'purchaseOrdersStats', 'topMaterials', 'materialsByCategory', 'lowStockAlerts'
        ));
    }

    /**
     * Sales Reports
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Sales summary
        $totalSales = SaleOrder::whereBetween('order_date', [$startDate, $endDate])
            ->sum('total_amount') ?? 0;

        $salesCount = SaleOrder::whereBetween('order_date', [$startDate, $endDate])->count();

        // Invoices summary
        $invoicesStats = [
            'total' => Invoice::whereBetween('invoice_date', [$startDate, $endDate])->count(),
            'paid' => Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                ->where('status', 'paid')->count(),
            'pending' => Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                ->where('status', 'pending')->count(),
            'total_value' => Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                ->sum('total') ?? 0,
        ];

        // Top customers
        $topCustomers = Invoice::select('customer_id', DB::raw('SUM(total) as total_sales'), DB::raw('COUNT(*) as orders_count'))
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('customer_id')
            ->orderByDesc('total_sales')
            ->with('customer')
            ->take(10)
            ->get();

        // Monthly sales trend
        $monthlySales = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($start <= $end) {
            $monthStart = $start->copy()->startOfMonth();
            $monthEnd = $start->copy()->endOfMonth();

            $monthlySales[] = [
                'month' => $start->format('M Y'),
                'sales' => Invoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
                    ->where('status', 'paid')->sum('total') ?? 0,
                'count' => Invoice::whereBetween('invoice_date', [$monthStart, $monthEnd])->count(),
            ];

            $start->addMonth();
        }

        // Recent sales
        $recentSales = Invoice::with('customer')
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->latest()
            ->take(10)
            ->get();

        return view('reports.sales', compact(
            'startDate', 'endDate',
            'totalSales', 'salesCount', 'invoicesStats',
            'topCustomers', 'monthlySales', 'recentSales'
        ));
    }

    /**
     * Customers Reports
     */
    public function customers(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Basic customer stats
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        $inactiveCustomers = Customer::where('status', 'inactive')->count();
        $suspendedCustomers = Customer::where('status', 'suspended')->count();

        // New customers in selected period
        $newCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(25)
            ->get();

        // Customers revenue in selected period
        $revenueBaseQuery = Invoice::select(
                'customer_id',
                DB::raw('COUNT(*) as invoices_count'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('customer_id')
            ->with('customer');

        $topCustomers = (clone $revenueBaseQuery)
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        $revenueByCustomer = (clone $revenueBaseQuery)
            ->orderByDesc('total_revenue')
            ->get();

        $totalRevenue = $revenueByCustomer->sum('total_revenue');

        // Status distribution
        $statusStats = Customer::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Type distribution
        $typeStats = Customer::select('customer_type', DB::raw('COUNT(*) as count'))
            ->groupBy('customer_type')
            ->get();

        return view('reports.customers', compact(
            'startDate', 'endDate',
            'totalCustomers', 'activeCustomers', 'inactiveCustomers', 'suspendedCustomers',
            'newCustomers', 'topCustomers', 'revenueByCustomer', 'totalRevenue',
            'statusStats', 'typeStats'
        ));
    }

    /**
     * Vendors Reports
     */
    public function vendors(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Basic vendor stats
        $totalVendors = Vendor::count();
        $activeVendors = Vendor::where('is_active', true)->count();
        $inactiveVendors = $totalVendors - $activeVendors;

        // New vendors in selected period
        $newVendors = Vendor::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(25)
            ->get();

        // Purchases from vendors in selected period (Purchase Orders)
        $purchasesBaseQuery = PurchaseOrder::select(
                'vendor_id',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total_amount) as total_purchased')
            )
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('vendor_id')
            ->with('vendor');

        $topVendors = (clone $purchasesBaseQuery)
            ->orderByDesc('total_purchased')
            ->take(10)
            ->get();

        $purchasesByVendor = (clone $purchasesBaseQuery)
            ->orderByDesc('total_purchased')
            ->get();

        $totalPurchases = $purchasesByVendor->sum('total_purchased');

        return view('reports.vendors', compact(
            'startDate', 'endDate',
            'totalVendors', 'activeVendors', 'inactiveVendors',
            'newVendors', 'topVendors', 'purchasesByVendor', 'totalPurchases'
        ));
    }

    /**
     * Project Reports
     */
    public function projects(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfYear()->format('Y-m-d'));

        // Projects summary
        $projectsStats = [
            'total' => Project::count(),
            'active' => Project::where('status', 'in_progress')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
        ];

        // Tasks summary
        $tasksStats = [
            'total' => Task::count(),
            'completed' => Task::where('status', 'completed')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'pending' => Task::where('status', 'pending')->count(),
        ];

        // Projects by status
        $projectsByStatus = Project::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Recent projects
        $recentProjects = Project::with(['manager', 'tasks'])
            ->latest()
            ->take(10)
            ->get();

        // Overdue tasks
        $overdueTasks = Task::where('status', '!=', 'completed')
            ->where('due_date', '<', now())
            ->with(['employee', 'project'])
            ->take(10)
            ->get();

        // Project completion rate
        $completionRate = $projectsStats['total'] > 0
            ? round(($projectsStats['completed'] / $projectsStats['total']) * 100, 1)
            : 0;

        return view('reports.projects', compact(
            'startDate', 'endDate',
            'projectsStats', 'tasksStats', 'projectsByStatus',
            'recentProjects', 'overdueTasks', 'completionRate'
        ));
    }

    /**
     * Custom Reports Builder
     */
    public function custom(Request $request)
    {
        $availableModules = [
            'invoices' => 'Invoices',
            'payments' => 'Payment Vouchers',
            'receipts' => 'Receipt Vouchers',
            'employees' => 'Employees',
            'payroll' => 'Payroll',
            'attendance' => 'Attendance',
            'leave' => 'Leave Requests',
            'materials' => 'Materials',
            'purchase_orders' => 'Purchase Orders',
            'sale_orders' => 'Sale Orders',
            'customers' => 'Customers',
            'vendors' => 'Vendors',
            'projects' => 'Projects',
            'tasks' => 'Tasks',
        ];

        return view('reports.custom', compact('availableModules'));
    }

    /**
     * Generate Custom Report
     */
    public function generateCustom(Request $request)
    {
        $module = $request->get('module');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $columns = $request->get('columns', []);
        $format = $request->get('format', 'view');

        $data = $this->getModuleData($module, $startDate, $endDate, $columns);

        if ($format === 'csv') {
            return $this->exportCsv($data, $module);
        }

        if ($format === 'pdf') {
            return $this->exportPdf($data, $module);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'columns' => $columns,
        ]);
    }

    /**
     * Get module data for custom report
     */
    private function getModuleData($module, $startDate, $endDate, $columns)
    {
        $dateColumn = 'created_at';

        switch ($module) {
            case 'invoices':
                $dateColumn = 'invoice_date';
                return Invoice::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('customer')
                    ->get();

            case 'payments':
                $dateColumn = 'voucher_date';
                return PaymentVoucher::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with(['company', 'account'])
                    ->get();

            case 'receipts':
                $dateColumn = 'voucher_date';
                return ReceiptVoucher::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with(['company', 'account'])
                    ->get();

            case 'employees':
                return Employee::where('is_active', true)
                    ->with(['department', 'position'])
                    ->get();

            case 'payroll':
                $dateColumn = 'pay_date';
                return Payroll::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('employee')
                    ->get();

            case 'attendance':
                $dateColumn = 'date';
                return Attendance::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('employee')
                    ->get();

            case 'leave':
                $dateColumn = 'start_date';
                return Leave::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('employee')
                    ->get();

            case 'materials':
                return Material::where('is_active', true)
                    ->with('category')
                    ->get();

            case 'purchase_orders':
                $dateColumn = 'order_date';
                return PurchaseOrder::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('vendor')
                    ->get();

            case 'sale_orders':
                $dateColumn = 'order_date';
                return SaleOrder::whereBetween($dateColumn, [$startDate, $endDate])
                    ->with('customer')
                    ->get();

            case 'customers':
                return Customer::whereBetween('created_at', [$startDate, $endDate])->get();

            case 'vendors':
                return Vendor::whereBetween('created_at', [$startDate, $endDate])->get();

            case 'projects':
                return Project::whereBetween('created_at', [$startDate, $endDate])
                    ->with('manager')
                    ->get();

            case 'tasks':
                return Task::whereBetween('created_at', [$startDate, $endDate])
                    ->with(['employee', 'project'])
                    ->get();

            default:
                return collect();
        }
    }

    /**
     * Export to CSV
     */
    private function exportCsv($data, $module)
    {
        $filename = $module . '_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            if ($data->isNotEmpty()) {
                // Header row
                fputcsv($file, array_keys($data->first()->toArray()));

                // Data rows
                foreach ($data as $row) {
                    fputcsv($file, $row->toArray());
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to PDF (placeholder - needs PDF library)
     */
    private function exportPdf($data, $module)
    {
        // This would require a PDF library like DomPDF or TCPDF
        // For now, return JSON
        return response()->json([
            'success' => false,
            'message' => 'PDF export requires additional configuration',
        ]);
    }

    /**
     * Get report data via AJAX
     */
    public function getData(Request $request)
    {
        $type = $request->get('type');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        switch ($type) {
            case 'revenue_chart':
                return $this->getRevenueChartData($startDate, $endDate);

            case 'expense_chart':
                return $this->getExpenseChartData($startDate, $endDate);

            case 'attendance_chart':
                return $this->getAttendanceChartData($startDate, $endDate);

            case 'sales_chart':
                return $this->getSalesChartData($startDate, $endDate);

            default:
                return response()->json(['error' => 'Invalid chart type']);
        }
    }

    private function getRevenueChartData($startDate, $endDate)
    {
        $data = Invoice::selectRaw('DATE_FORMAT(invoice_date, "%Y-%m") as month, SUM(total) as total')
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $data->pluck('month'),
            'data' => $data->pluck('total'),
        ]);
    }

    private function getExpenseChartData($startDate, $endDate)
    {
        $data = PaymentVoucher::selectRaw('DATE_FORMAT(voucher_date, "%Y-%m") as month, SUM(total_amount) as total')
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $data->pluck('month'),
            'data' => $data->pluck('total'),
        ]);
    }

    private function getAttendanceChartData($startDate, $endDate)
    {
        $present = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')->count();
        $absent = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'absent')->count();
        $late = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('is_late', true)->count();

        return response()->json([
            'labels' => ['Present', 'Absent', 'Late'],
            'data' => [$present, $absent, $late],
        ]);
    }

    private function getSalesChartData($startDate, $endDate)
    {
        $data = Invoice::selectRaw('DATE_FORMAT(invoice_date, "%Y-%m") as month, COUNT(*) as count, SUM(total) as total')
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $data->pluck('month'),
            'counts' => $data->pluck('count'),
            'totals' => $data->pluck('total'),
        ]);
    }
}
