<?php

if (!function_exists('notify_success')) {
    /**
     * إرسال إشعار نجاح
     */
    function notify_success(string $message, string $title = 'نجح!'): void
    {
        session()->flash('notification', [
            'type' => 'success',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('notify_error')) {
    /**
     * إرسال إشعار خطأ
     */
    function notify_error(string $message, string $title = 'خطأ!'): void
    {
        session()->flash('notification', [
            'type' => 'error',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('notify_warning')) {
    /**
     * إرسال إشعار تحذير
     */
    function notify_warning(string $message, string $title = 'تحذير!'): void
    {
        session()->flash('notification', [
            'type' => 'warning',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('notify_info')) {
    /**
     * إرسال إشعار معلومات
     */
    function notify_info(string $message, string $title = 'معلومات'): void
    {
        session()->flash('notification', [
            'type' => 'info',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('notify_error_code')) {
    /**
     * Send error notification by code
     */
    function notify_error_code(int $code, string $customMessage = null): void
    {
        $errorCodes = [
            // Database Errors (1000-1999)
            1001 => 'Database connection error',
            1002 => 'Failed to save data',
            1003 => 'Failed to update data',
            1004 => 'Failed to delete data',
            1005 => 'Data not found',
            1006 => 'Unique constraint violation',
            1007 => 'Foreign key constraint violation',
            1008 => 'Query building error',

            // Validation Errors (2000-2999)
            2001 => 'Invalid input data',
            2002 => 'Required field missing',
            2003 => 'Invalid data format',
            2004 => 'Value out of allowed range',
            2005 => 'Email already exists',
            2006 => 'Password too weak',

            // File System Errors (3000-3999)
            3001 => 'File upload failed',
            3002 => 'Unsupported file type',
            3003 => 'File too large',
            3004 => 'File deletion failed',

            // Permission Errors (4000-4999)
            4001 => 'Access denied',
            4002 => 'Session expired',
            4003 => 'Account blocked',

            // System Errors (5000-5999)
            5001 => 'Internal system error',
            5002 => 'Service temporarily unavailable',
            5003 => 'Request processing error',
            5004 => 'Network error',

            // Business Logic Errors (6000-6999)
            6001 => 'Cannot delete item due to related data',
            6002 => 'Insufficient balance',
            6003 => 'Invalid time period',
            6004 => 'Item in invalid state'
        ];

        $message = $customMessage ?? ($errorCodes[$code] ?? 'Unknown error');
        $title = "Error {$code}";

        notify_error($message, $title);
    }
}

if (!function_exists('notify_validation_errors')) {
    /**
     * Send validation errors notifications
     */
    function notify_validation_errors(\Illuminate\Support\MessageBag $errors): void
    {
        $messages = [];
        foreach ($errors->all() as $error) {
            $messages[] = $error;
        }

        if (count($messages) === 1) {
            notify_error($messages[0], 'Data Error');
        } else {
            notify_error('Please correct the following errors: ' . implode(', ', $messages), 'Multiple Errors');
        }
    }
}

if (!function_exists('notify_created')) {
    /**
     * Success notification for creation
     */
    function notify_created(string $itemName = 'Item'): void
    {
        notify_success("{$itemName} created successfully", 'Created');
    }
}

if (!function_exists('notify_updated')) {
    /**
     * Success notification for update
     */
    function notify_updated(string $itemName = 'Item'): void
    {
        notify_success("{$itemName} updated successfully", 'Updated');
    }
}

if (!function_exists('notify_deleted')) {
    /**
     * Success notification for deletion
     */
    function notify_deleted(string $itemName = 'Item'): void
    {
        notify_success("{$itemName} deleted successfully", 'Deleted');
    }
}

if (!function_exists('notify_exported')) {
    /**
     * Success notification for export
     */
    function notify_exported(string $itemName = 'Data'): void
    {
        notify_success("{$itemName} exported successfully", 'Exported');
    }
}

if (!function_exists('notify_imported')) {
    /**
     * Success notification for import
     */
    function notify_imported(string $itemName = 'Data'): void
    {
        notify_success("{$itemName} imported successfully", 'Imported');
    }
}
