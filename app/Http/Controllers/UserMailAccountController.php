<?php

namespace App\Http\Controllers;

use App\Models\UserMailAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserMailAccountController extends Controller
{
    /**
     * Store or update the current user's default mail account settings.
     */
    public function save(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'label' => 'nullable|string|max:255',
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'nullable|string|max:10',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string|max:255',
            'incoming_protocol' => 'required|in:imap,pop3',
            'incoming_host' => 'nullable|string|max:255',
            'incoming_port' => 'nullable|integer|min:1|max:65535',
            'incoming_encryption' => 'nullable|string|max:10',
            'incoming_username' => 'nullable|string|max:255',
            'incoming_password' => 'nullable|string|max:255',
            'from_name' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $data = $validator->validated();

        $account = UserMailAccount::firstOrNew([
            'user_id' => $user->id,
            'is_default' => true,
        ]);

        $account->fill($data);
        $account->user_id = $user->id;
        $account->is_default = true;
        $account->is_active = true;
        $account->save();

        return response()->json([
            'success' => true,
            'message' => 'Mail account settings saved successfully.',
        ]);
    }

    /**
     * Test SMTP connectivity for the given settings (no real email is sent).
     */
    public function test(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $host = $data['smtp_host'];
        $port = (int) $data['smtp_port'];
        $encryption = $data['smtp_encryption'] ?? null;

        // For SSL we prepend ssl://, otherwise plain TCP. STARTTLS is not negotiated here.
        $remote = $encryption === 'ssl' ? "ssl://{$host}" : $host;

        $errno = 0;
        $errstr = '';

        try {
            $timeout = 10; // seconds
            $connection = @fsockopen($remote, $port, $errno, $errstr, $timeout);

            if (! $connection) {
                return response()->json([
                    'success' => false,
                    'message' => "Unable to connect to SMTP server: {$errstr} ({$errno})",
                ], 500);
            }

            fclose($connection);

            return response()->json([
                'success' => true,
                'message' => 'SMTP connection successful (host and port are reachable).',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'SMTP connection failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
