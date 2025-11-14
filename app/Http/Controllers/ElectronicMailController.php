<?php

namespace App\Http\Controllers;

use App\Models\ElectronicMail;
use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ElectronicMailController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index(Request $request)
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        // Get counts for sidebar
        $inboxCount = ElectronicMail::inbox()->unread()->count();
        $sentCount = ElectronicMail::sent()->count();
        $draftCount = ElectronicMail::draft()->where('sender_user_id', auth()->id())->count();
        $starredCount = ElectronicMail::starred()->where('recipient_user_id', auth()->id())->count();

        $currentFolder = $request->get('folder', 'inbox');

        $mailAccount = Auth::check() ? Auth::user()->defaultMailAccount : null;

        return view('electronic-mail.index', compact(
            'companies',
            'departments',
            'users',
            'inboxCount',
            'sentCount',
            'draftCount',
            'starredCount',
            'currentFolder',
            'mailAccount'
        ));
    }

    public function datatable(Request $request): JsonResponse
    {
        $folder = $request->get('folder', 'inbox');

        $query = ElectronicMail::query()
            ->with(['sender:id,name', 'recipient:id,name', 'department:id,name']);

        // Apply folder filter
        switch ($folder) {
            case 'inbox':
                $query->inbox();
                break;
            case 'sent':
                $query->sent();
                break;
            case 'draft':
                $query->draft()->where('sender_user_id', auth()->id());
                break;
            case 'starred':
                $query->starred()->where('recipient_user_id', auth()->id());
                break;
        }

        // Apply search filter
        if ($request->filled('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('sender_info', function ($mail) {
                $name = $mail->type === 'incoming' ? ($mail->sender_name ?: 'Unknown') : ($mail->recipient_name ?: 'Unknown');
                $email = $mail->type === 'incoming' ? $mail->sender_email : $mail->recipient_email;
                return "<div><strong>{$name}</strong><br><small class='text-slate-500'>{$email}</small></div>";
            })
            ->addColumn('subject', function ($mail) {
                $starIcon = $mail->is_starred ? 'Star' : 'Star';
                $starClass = $mail->is_starred ? 'text-yellow-500' : 'text-slate-400';
                return "
                    <div class='flex items-center gap-2'>
                        <button onclick='toggleStar({$mail->id})' class='{$starClass} hover:text-yellow-600'>
                            <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 24 24'>
                                <path d='M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'/>
                            </svg>
                        </button>
                        <span class='" . ($mail->is_read ? 'text-slate-600' : 'font-semibold') . "'>{$mail->subject}</span>
                    </div>
                ";
            })
            ->addColumn('priority_badge', function ($mail) {
                $class = $mail->priority_badge_class;
                $label = ucfirst($mail->priority);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('status_badge', function ($mail) {
                $class = $mail->status_badge_class;
                $label = ucfirst(str_replace('_', ' ', $mail->status));
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('date', function ($mail) {
                return $mail->formatted_date;
            })
            ->addColumn('actions', function ($mail) {
                $readClass = $mail->is_read ? 'text-slate-400' : 'text-blue-600';
                return "
                    <div class='flex items-center gap-2'>
                        <button onclick='viewMail({$mail->id})' class='{$readClass} hover:text-blue-800' title='View'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                            </svg>
                        </button>
                        <button onclick='deleteMail({$mail->id})' class='text-red-500 hover:text-red-700' title='Delete'>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                            </svg>
                        </button>
                    </div>
                ";
            })
            ->rawColumns(['sender_info', 'subject', 'priority_badge', 'status_badge', 'actions'])
            ->make(true);
    }

    public function show(ElectronicMail $electronicMail): JsonResponse
    {
        // Mark as read if it's incoming and not read yet
        if ($electronicMail->type === 'incoming' && !$electronicMail->is_read) {
            $electronicMail->markAsRead();
        }

        $electronicMail->load(['sender', 'recipient', 'department', 'company', 'replies']);

        return response()->json([
            'success' => true,
            'mail' => $electronicMail
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:incoming,outgoing',
            'status' => 'required|in:draft,sent,received',
            'priority' => 'required|in:low,normal,high,urgent',
            'recipient_name' => 'nullable|string|max:255',
            'recipient_email' => 'nullable|email',
            'recipient_user_id' => 'nullable|exists:users,id',
            'sender_name' => 'nullable|string|max:255',
            'sender_email' => 'nullable|email',
            'sender_user_id' => 'nullable|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Handle file attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('electronic-mail-attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                }
                $data['attachments'] = $attachments;
            }

            // Generate code
            $data['code'] = $this->codeGenerator->generate('electronic_mails');

            // Set sent_at for sent mails
            if ($request->status === 'sent') {
                $data['sent_at'] = now();
            }

            // Auto-set sender/recipient based on type
            if ($request->type === 'outgoing') {
                $data['sender_user_id'] = auth()->id();
                $data['sender_name'] = auth()->user()->name;
                $data['sender_email'] = auth()->user()->email;
            } elseif ($request->type === 'incoming') {
                $data['recipient_user_id'] = auth()->id();
            }

            ElectronicMail::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Electronic mail created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create electronic mail: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, ElectronicMail $electronicMail): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,sent,received,read,archived',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_starred' => 'boolean',
            'is_read' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $electronicMail->update($request->only([
                'subject', 'content', 'status', 'priority', 'is_starred', 'is_read'
            ]));

            // Update read_at if marking as read
            if ($request->boolean('is_read') && !$electronicMail->read_at) {
                $electronicMail->update(['read_at' => now()]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Electronic mail updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update electronic mail: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(ElectronicMail $electronicMail): JsonResponse
    {
        try {
            $electronicMail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Electronic mail deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete electronic mail: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStar(ElectronicMail $electronicMail): JsonResponse
    {
        $electronicMail->toggleStar();

        return response()->json([
            'success' => true,
            'is_starred' => $electronicMail->is_starred
        ]);
    }

    public function markAsRead(ElectronicMail $electronicMail): JsonResponse
    {
        $electronicMail->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Mail marked as read'
        ]);
    }

    public function compose()
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();
        $users = User::select('id', 'name', 'email')->get();

        return view('electronic-mail.compose', compact('companies', 'departments', 'users'));
    }
}
