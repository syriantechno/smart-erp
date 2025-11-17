<?php

namespace App\Http\Controllers;

use App\Models\AiInteraction;
use App\Models\AiAutomation;
use App\Models\AiGeneratedContent;
use App\Services\AiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AiController extends Controller
{
    public function __construct(private AiService $aiService)
    {
    }

    public function index()
    {
        $stats = [
            'total_interactions' => AiInteraction::forUser(auth()->id())->count(),
            'completed_interactions' => AiInteraction::forUser(auth()->id())->completed()->count(),
            'generated_content' => AiGeneratedContent::where('user_id', auth()->id())->count(),
            'active_automations' => AiAutomation::where('created_by', auth()->id())->active()->count(),
        ];

        return view('ai.index', compact('stats'));
    }

    public function chat()
    {
        // Redirect to main AI page where the chat is handled via modal
        return redirect()->route('ai.index');
    }

    public function interact(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'type' => 'required|in:query,command,analysis,generation,chat',
            'context' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // Create interaction record
            $interaction = AiInteraction::create([
                'session_id' => $request->session_id ?? Str::uuid(),
                'interaction_type' => $request->type,
                'user_input' => $request->message,
                'status' => 'processing',
                'user_id' => auth()->id(),
            ]);

            // Get AI response
            $context = array_merge($request->context ?? [], ['user_id' => auth()->id()]);
            $result = $this->aiService->generateResponse($request->message, $context, $request->type);

            if ($result['success']) {
                $interaction->markAsCompleted($result['response'], $result['metadata']);

                // Handle specific command executions
                if ($request->type === 'command') {
                    $commandResult = $this->aiService->executeCommand($request->message, $context);
                    if ($commandResult['success']) {
                        $interaction->update([
                            'ai_response' => $interaction->ai_response . "\n\n**Action Result:** " . ($commandResult['message'] ?? 'Command executed successfully'),
                            'metadata' => array_merge($interaction->metadata ?? [], ['command_result' => $commandResult])
                        ]);
                    }
                }
            } else {
                $interaction->markAsFailed($result['error'] ?? 'Unknown error');
            }

            DB::commit();

            return response()->json([
                'success' => $result['success'],
                'response' => $interaction->ai_response,
                'interaction_id' => $interaction->id,
                'metadata' => $interaction->metadata,
                'error' => $result['error'] ?? null,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => 'Failed to process AI interaction: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function datatable(Request $request): JsonResponse
    {
        $query = AiInteraction::forUser(auth()->id());

        if ($request->filled('type_filter') && $request->type_filter !== '') {
            $query->where('interaction_type', $request->type_filter);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $query->where('status', $request->status_filter);
        }

        return DataTables::of($query)
            ->addColumn('type_badge', function ($interaction) {
                $class = match($interaction->interaction_type) {
                    'query' => 'bg-blue-100 text-blue-700',
                    'command' => 'bg-green-100 text-green-700',
                    'analysis' => 'bg-purple-100 text-purple-700',
                    'generation' => 'bg-yellow-100 text-yellow-700',
                    'chat' => 'bg-indigo-100 text-indigo-700',
                };
                $label = ucfirst($interaction->interaction_type);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('status_badge', function ($interaction) {
                $class = match($interaction->status) {
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'completed' => 'bg-green-100 text-green-700',
                    'failed' => 'bg-red-100 text-red-700',
                };
                $label = ucfirst($interaction->status);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('cost_info', function ($interaction) {
                if ($interaction->cost > 0) {
                    return $interaction->formatted_cost . ' (' . $interaction->tokens_used . ' tokens)';
                }
                return '-';
            })
            ->addColumn('actions', function ($interaction) {
                return "
                    <button onclick='viewInteraction({$interaction->id})' class='text-blue-600 hover:text-blue-800 mr-2' title='View Details'>
                        <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                        </svg>
                    </button>
                    <button onclick='retryInteraction({$interaction->id})' class='text-green-600 hover:text-green-800' title='Retry' " . ($interaction->status === 'completed' ? 'disabled' : '') . ">
                        <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'/>
                        </svg>
                    </button>
                ";
            })
            ->rawColumns(['type_badge', 'status_badge', 'actions'])
            ->make(true);
    }

    public function adminUsers(): JsonResponse
    {
        // Admin-only: list users who have AI interactions
        $user = auth()->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $users = AiInteraction::with('user')
            ->select('user_id')
            ->whereNotNull('user_id')
            ->distinct()
            ->get()
            ->map(function (AiInteraction $interaction) {
                return [
                    'id' => $interaction->user?->id,
                    'name' => $interaction->user?->name ?? 'Unknown',
                    'email' => $interaction->user?->email ?? null,
                ];
            })
            ->filter(fn ($u) => !empty($u['id']))
            ->values();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function adminRecent(Request $request): JsonResponse
    {
        // Admin-only: get recent interactions, optionally filtered by user_id
        $user = auth()->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $query = AiInteraction::with('user')->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $interactions = $query
            ->limit(20)
            ->get()
            ->map(function (AiInteraction $interaction) {
                return [
                    'id' => $interaction->id,
                    'user_name' => $interaction->user?->name ?? 'Unknown',
                    'user_email' => $interaction->user?->email ?? null,
                    'interaction_type' => $interaction->interaction_type,
                    'status' => $interaction->status,
                    'user_input' => $interaction->user_input,
                    'formatted_date' => $interaction->formatted_date,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $interactions,
        ]);
    }

    public function show(AiInteraction $aiInteraction): JsonResponse
    {
        // Check ownership
        if ($aiInteraction->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        return response()->json([
            'success' => true,
            'interaction' => $aiInteraction->load('generatedContent')
        ]);
    }

    public function retry(AiInteraction $aiInteraction): JsonResponse
    {
        // Check ownership
        if ($aiInteraction->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if ($aiInteraction->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Interaction already completed'], 400);
        }

        try {
            $aiInteraction->update(['status' => 'processing']);

            $result = $this->aiService->generateResponse(
                $aiInteraction->user_input,
                ['user_id' => $aiInteraction->user_id],
                $aiInteraction->interaction_type
            );

            if ($result['success']) {
                $aiInteraction->markAsCompleted($result['response'], $result['metadata']);
            } else {
                $aiInteraction->markAsFailed($result['error'] ?? 'Unknown error');
            }

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success'] ? 'Interaction completed' : 'Interaction failed',
            ]);

        } catch (\Exception $e) {
            $aiInteraction->markAsFailed($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retry interaction',
            ], 500);
        }
    }

    public function automations()
    {
        $automations = AiAutomation::where('created_by', auth()->id())->get();

        return view('ai.automations', compact('automations'));
    }

    public function createAutomation(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'automation_type' => 'required|in:data_entry,report_generation,analysis,workflow_automation',
            'configuration' => 'required|array',
        ]);

        try {
            $automation = AiAutomation::create([
                'name' => $request->name,
                'description' => $request->description,
                'automation_type' => $request->automation_type,
                'configuration' => $request->configuration,
                'created_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Automation created successfully',
                'automation' => $automation,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create automation: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function generatedContent()
    {
        $content = AiGeneratedContent::where('user_id', auth()->id())
                                   ->latest()
                                   ->paginate(20);

        return view('ai.generated-content', compact('content'));
    }

    public function rateContent(Request $request, AiGeneratedContent $content): JsonResponse
    {
        if ($content->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $request->validate([
            'rating' => 'required|in:poor,fair,good,excellent',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $content->update([
            'quality_rating' => $request->rating,
            'user_feedback' => $request->feedback,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Content rated successfully',
        ]);
    }

    public function analytics()
    {
        $userId = auth()->id();

        $analytics = [
            'total_interactions' => AiInteraction::forUser($userId)->count(),
            'completed_interactions' => AiInteraction::forUser($userId)->completed()->count(),
            'failed_interactions' => AiInteraction::forUser($userId)->where('status', 'failed')->count(),
            'total_tokens' => AiInteraction::forUser($userId)->sum('tokens_used'),
            'total_cost' => AiInteraction::forUser($userId)->sum('cost'),
            'most_used_type' => AiInteraction::forUser($userId)
                                           ->select('interaction_type', DB::raw('count(*) as count'))
                                           ->groupBy('interaction_type')
                                           ->orderByDesc('count')
                                           ->first()?->interaction_type,
            'generated_content_count' => AiGeneratedContent::where('user_id', $userId)->count(),
        ];

        // Monthly usage for the last 6 months
        $monthlyUsage = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyUsage[] = [
                'month' => $date->format('M Y'),
                'interactions' => AiInteraction::forUser($userId)
                                             ->whereYear('created_at', $date->year)
                                             ->whereMonth('created_at', $date->month)
                                             ->count(),
                'cost' => AiInteraction::forUser($userId)
                                      ->whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->sum('cost'),
            ];
        }

        return view('ai.analytics', compact('analytics', 'monthlyUsage'));
    }

    public function isAvailable(): JsonResponse
    {
        return response()->json([
            'available' => $this->aiService->isAvailable(),
        ]);
    }
}
