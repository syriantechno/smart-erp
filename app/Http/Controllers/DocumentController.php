<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentShare;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index(Request $request)
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();

        // Get root categories for the current company
        $categories = DocumentCategory::active()
                                    ->forCompany(auth()->user()->company_id ?? null)
                                    ->root()
                                    ->orderBy('sort_order')
                                    ->orderBy('name')
                                    ->get();

        $currentCategory = $request->get('category');
        $search = $request->get('search');

        return view('documents.index', compact(
            'companies',
            'departments',
            'categories',
            'currentCategory',
            'search'
        ));
    }

    public function datatable(Request $request): JsonResponse
    {
        $query = Document::with(['category', 'uploader', 'department', 'company']);

        // Filter by company
        if (auth()->user()->company_id) {
            $query->where('company_id', auth()->user()->company_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $categoryIds = $this->getCategoryAndChildrenIds($request->category_id);
            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by type
        if ($request->filled('type_filter') && $request->type_filter !== '') {
            $query->where('document_type', $request->type_filter);
        }

        // Filter by status
        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $query->where('status', $request->status_filter);
        }

        // Filter by access level
        if ($request->filled('access_filter') && $request->access_filter !== '') {
            $query->where('access_level', $request->access_filter);
        }

        // Search
        if ($request->filled('search') && $request->search !== '') {
            $query->search($request->search);
        }

        // Filter documents user can access
        $query->where(function ($q) {
            $user = auth()->user();

            // Public documents
            $q->where('access_level', 'public');

            // Internal documents for company
            if ($user->company_id) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->where('access_level', 'internal')
                         ->where('company_id', $user->company_id);
                });
            }

            // Department documents
            if ($user->department_id) {
                $q->orWhere(function ($subQ) use ($user) {
                    $subQ->whereIn('access_level', ['confidential', 'internal'])
                         ->where('department_id', $user->department_id);
                });
            }

            // Restricted documents shared with user
            $q->orWhere(function ($subQ) use ($user) {
                $subQ->where('access_level', 'restricted')
                     ->whereHas('sharedUsers', function ($shareQ) use ($user) {
                         $shareQ->where('shared_with_user_id', $user->id);
                     });
            });

            // Documents uploaded by user
            $q->orWhere('uploaded_by', $user->id);
        });

        return DataTables::of($query)
            ->addColumn('category_name', function ($document) {
                return $document->category ? $document->category->name : 'Uncategorized';
            })
            ->addColumn('uploader_name', function ($document) {
                return $document->uploader ? $document->uploader->name : 'Unknown';
            })
            ->addColumn('type_badge', function ($document) {
                return "<span class='px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700'>" .
                       ucfirst(str_replace('_', ' ', $document->document_type)) . "</span>";
            })
            ->addColumn('status_badge', function ($document) {
                $class = $document->status_badge_class;
                $label = ucfirst($document->status);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('access_badge', function ($document) {
                $class = $document->access_level_badge_class;
                $label = ucfirst($document->access_level);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('file_info', function ($document) {
                $icon = $document->type_icon;
                return "
                    <div class='flex items-center'>
                        <x-base.lucide icon='{$icon}' class='w-4 h-4 mr-2 text-gray-500' />
                        <div>
                            <div class='text-sm font-medium'>{$document->file_name}</div>
                            <div class='text-xs text-gray-500'>{$document->file_size_formatted}</div>
                        </div>
                    </div>
                ";
            })
            ->addColumn('expiry_info', function ($document) {
                if (!$document->expiry_date) return '-';

                $days = $document->days_until_expiry;
                $class = $days <= 0 ? 'text-red-600' : ($days <= 30 ? 'text-yellow-600' : 'text-gray-600');
                $text = $days <= 0 ? 'Expired' : ($days . ' days');

                return "<span class='{$class}'>{$text}</span>";
            })
            ->addColumn('actions', function ($document) {
                $actions = '';

                if ($document->canBeAccessedBy(auth()->user())) {
                    $actions .= "
                        <button onclick='viewDocument({$document->id})' class='text-blue-600 hover:text-blue-800 mr-2' title='View'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                            </svg>
                        </button>
                        <a href='{$document->file_url}' target='_blank' class='text-green-600 hover:text-green-800 mr-2' title='Download'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/>
                            </svg>
                        </a>
                    ";
                }

                // Edit and delete for owners or admins
                if ($document->uploaded_by === auth()->id() || auth()->user()->hasRole('admin')) {
                    $actions .= "
                        <button onclick='editDocument({$document->id})' class='text-yellow-600 hover:text-yellow-800 mr-2' title='Edit'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                            </svg>
                        </button>
                        <button onclick='deleteDocument({$document->id}, \"{$document->title}\")' class='text-red-600 hover:text-red-800' title='Delete'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                            </svg>
                        </button>
                    ";
                }

                return "<div class='flex items-center justify-center gap-2'>{$actions}</div>";
            })
            ->rawColumns(['type_badge', 'status_badge', 'access_badge', 'file_info', 'expiry_info', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();
        $categories = DocumentCategory::active()
                                    ->forCompany(auth()->user()->company_id ?? null)
                                    ->orderBy('name')
                                    ->get();

        return view('documents.create', compact('companies', 'departments', 'categories'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:contract,invoice,report,certificate,license,agreement,policy,manual,other',
            'access_level' => 'required|in:public,internal,confidential,restricted',
            'category_id' => 'nullable|exists:document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'expiry_date' => 'nullable|date|after:today',
            'requires_signature' => 'boolean',
            'tags' => 'nullable|array',
            'file' => 'required|file|max:51200', // 50MB max
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $path = $file->store('documents', 'public');

            $document = Document::create([
                'code' => $this->codeGenerator->generate('documents'),
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => basename($path),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'document_type' => $request->document_type,
                'access_level' => $request->access_level,
                'category_id' => $request->category_id,
                'department_id' => $request->department_id,
                'company_id' => $request->company_id ?: auth()->user()->company_id,
                'uploaded_by' => auth()->id(),
                'expiry_date' => $request->expiry_date,
                'requires_signature' => $request->boolean('requires_signature'),
                'tags' => $request->tags,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => $document,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Document $document): JsonResponse
    {
        if (!$document->canBeAccessedBy(auth()->user())) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $document->load(['category', 'uploader', 'department', 'company', 'versions', 'shares']);

        return response()->json([
            'success' => true,
            'document' => $document,
        ]);
    }

    public function update(Request $request, Document $document): JsonResponse
    {
        if ($document->uploaded_by !== auth()->id() && !auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:contract,invoice,report,certificate,license,agreement,policy,manual,other',
            'access_level' => 'required|in:public,internal,confidential,restricted',
            'category_id' => 'nullable|exists:document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'expiry_date' => 'nullable|date',
            'requires_signature' => 'boolean',
            'tags' => 'nullable|array',
            'status' => 'required|in:active,archived',
        ]);

        try {
            $document->update($request->only([
                'title', 'description', 'document_type', 'access_level',
                'category_id', 'department_id', 'expiry_date', 'requires_signature',
                'tags', 'status'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Document updated successfully',
                'document' => $document,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update document: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Document $document): JsonResponse
    {
        if ($document->uploaded_by !== auth()->id() && !auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        try {
            $document->deleteFile();
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete document: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Categories Management
    public function categories()
    {
        $categories = DocumentCategory::with(['children', 'company'])
                                    ->forCompany(auth()->user()->company_id ?? null)
                                    ->root()
                                    ->orderBy('sort_order')
                                    ->orderBy('name')
                                    ->get();

        return view('documents.categories', compact('categories'));
    }

    public function storeCategory(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:document_categories,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $category = DocumentCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color ?: '#3b82f6',
                'icon' => $request->icon ?: 'folder',
                'parent_id' => $request->parent_id,
                'company_id' => auth()->user()->company_id,
                'sort_order' => $request->sort_order ?: 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => $category,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateCategory(Request $request, DocumentCategory $category): JsonResponse
    {
        if ($category->company_id !== auth()->user()->company_id && !auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $category->update($request->only([
                'name', 'description', 'color', 'icon', 'sort_order'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'category' => $category,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyCategory(DocumentCategory $category): JsonResponse
    {
        if ($category->company_id !== auth()->user()->company_id && !auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($category->documents()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with documents. Move or delete documents first.',
            ], 400);
        }

        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Helper methods
    private function getCategoryAndChildrenIds($categoryId)
    {
        $category = DocumentCategory::find($categoryId);
        if (!$category) return [$categoryId];

        $ids = [$categoryId];

        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getCategoryAndChildrenIds($child->id));
        }

        return $ids;
    }
}
