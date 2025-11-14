<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Get unread notifications count.
     */
    public function unreadCount(): JsonResponse
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get recent unread notifications.
     */
    public function recent(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);

        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Request $request, Notification $notification): JsonResponse
    {
        // Ensure user owns the notification
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification): JsonResponse
    {
        // Ensure user owns the notification
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * Delete all notifications.
     */
    public function destroyAll(): JsonResponse
    {
        Notification::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications deleted',
        ]);
    }

    /**
     * Create a new notification.
     */
    public function createNotification(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string|in:info,success,warning,error',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'action_url' => 'nullable|string',
            'icon' => 'nullable|string',
            'data' => 'nullable|array',
        ]);

        $notification = Notification::create([
            'type' => $request->type,
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
            'created_by' => Auth::id(),
            'action_url' => $request->action_url,
            'icon' => $request->icon,
            'data' => $request->data,
        ]);

        return response()->json([
            'success' => true,
            'data' => $notification,
            'message' => 'Notification created successfully',
        ]);
    }

    /**
     * Send notification to multiple users.
     */
    public function sendToUsers(Request $request): JsonResponse
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'type' => 'required|string|in:info,success,warning,error',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'action_url' => 'nullable|string',
            'icon' => 'nullable|string',
            'data' => 'nullable|array',
        ]);

        $notifications = [];
        foreach ($request->user_ids as $userId) {
            $notifications[] = Notification::create([
                'type' => $request->type,
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => $userId,
                'created_by' => Auth::id(),
                'action_url' => $request->action_url,
                'icon' => $request->icon,
                'data' => $request->data,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'message' => 'Notifications sent to ' . count($notifications) . ' users',
        ]);
    }

    /**
     * Send notification to all users except current user.
     */
    public static function sendToAllUsers(string $title, string $message, string $type = 'info', string $actionUrl = null, string $icon = null): void
    {
        // Set default icon based on type if not provided
        if (!$icon) {
            $icon = match ($type) {
                'success' => 'CheckCircle',
                'error' => 'ExclamationCircle',
                'warning' => 'ExclamationTriangle',
                default => 'InformationCircle',
            };
        }

        $users = \App\Models\User::where('id', '!=', auth()->id())->get();

        foreach ($users as $user) {
            Notification::create([
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'user_id' => $user->id,
                'created_by' => auth()->id(),
                'action_url' => $actionUrl,
                'icon' => $icon,
            ]);
        }
    }

    /**
     * Send notification to specific user.
     */
    public static function sendToUser(int $userId, string $title, string $message, string $type = 'info', string $actionUrl = null, string $icon = null): void
    {
        Notification::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'user_id' => $userId,
            'created_by' => auth()->id(),
            'action_url' => $actionUrl,
            'icon' => $icon,
        ]);
    }

    /**
     * Send notification when position is created.
     */
    public static function positionCreated(\App\Models\Position $position): void
    {
        $title = 'New Position Added';
        $message = "Position '{$position->title}' has been added to department '{$position->department->name}'.";
        $actionUrl = route('hr.positions.index');

        self::sendToAllUsers($title, $message, 'success', $actionUrl, 'Plus');
    }

    /**
     * Send notification when department is created.
     */
    public static function departmentCreated(\App\Models\Department $department): void
    {
        $title = 'New Department Added';
        $message = "Department '{$department->name}' has been created.";
        $actionUrl = route('hr.departments.index');

        self::sendToAllUsers($title, $message, 'success', $actionUrl, 'Building');
    }

    /**
     * Send notification when employee is created.
     */
    public static function employeeCreated(\App\Models\Employee $employee): void
    {
        $title = 'New Employee Added';
        $message = "Employee '{$employee->first_name} {$employee->last_name}' has joined the company.";
        $actionUrl = route('hr.employees.index');

        self::sendToAllUsers($title, $message, 'success', $actionUrl, 'UserPlus');
    }
}
