<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmployeeDocumentController extends Controller
{
    public function index(Employee $employee): View
    {
        $documents = $employee->documents()
            ->active()
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('document_type');

        return view('hr.employees.documents.index', compact('employee', 'documents'));
    }

    public function create(Employee $employee): View
    {
        return view('hr.employees.documents.create', compact('employee'));
    }

    public function store(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'document_type' => 'required|in:passport,visa,id_card,license,certificate,other',
            'document_name' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'notes' => 'nullable|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            DB::beginTransaction();

            $document = new EmployeeDocument();
            $document->employee_id = $employee->id;
            $document->document_type = $validated['document_type'];
            $document->document_name = $validated['document_name'];
            $document->document_number = $validated['document_number'] ?? null;
            $document->issue_date = $validated['issue_date'] ?? null;
            $document->expiry_date = $validated['expiry_date'] ?? null;
            $document->notes = $validated['notes'] ?? null;

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . Str::slug($employee->employee_id) . '_' . Str::slug($validated['document_name']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('employee_documents', $filename, 'public');

                $document->file_path = $path;
                $document->file_name = $originalName;
            }

            $document->save();

            DB::commit();

            return redirect()->route('hr.employees.documents.index', $employee)
                ->with('success', 'Document uploaded successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error uploading document: ' . $e->getMessage());
        }
    }

    public function edit(Employee $employee, EmployeeDocument $document): View
    {
        // Ensure the document belongs to the employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        return view('hr.employees.documents.edit', compact('employee', 'document'));
    }

    public function update(Request $request, Employee $employee, EmployeeDocument $document): RedirectResponse
    {
        // Ensure the document belongs to the employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        $validated = $request->validate([
            'document_type' => 'required|in:passport,visa,id_card,license,certificate,other',
            'document_name' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'notes' => 'nullable|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $document->document_type = $validated['document_type'];
            $document->document_name = $validated['document_name'];
            $document->document_number = $validated['document_number'] ?? null;
            $document->issue_date = $validated['issue_date'] ?? null;
            $document->expiry_date = $validated['expiry_date'] ?? null;
            $document->notes = $validated['notes'] ?? null;
            $document->is_active = $request->boolean('is_active', true);

            // Handle file upload
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . Str::slug($employee->employee_id) . '_' . Str::slug($validated['document_name']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('employee_documents', $filename, 'public');

                $document->file_path = $path;
                $document->file_name = $originalName;
            }

            $document->save();

            DB::commit();

            return redirect()->route('hr.employees.documents.index', $employee)
                ->with('success', 'Document updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating document: ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee, EmployeeDocument $document): RedirectResponse
    {
        // Ensure the document belongs to the employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Delete file if exists
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            DB::commit();

            return redirect()->route('hr.employees.documents.index', $employee)
                ->with('success', 'Document deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting document: ' . $e->getMessage());
        }
    }

    public function download(Employee $employee, EmployeeDocument $document)
    {
        // Ensure the document belongs to the employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File not found');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_name ?? 'document_' . $document->id
        );
    }
}
