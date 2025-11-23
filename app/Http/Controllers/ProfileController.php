<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function updateSignature(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->boolean('remove_signature')) {
            if ($user->signature_path) {
                Storage::disk('public')->delete($user->signature_path);
                $user->forceFill(['signature_path' => null])->save();
            }

            return back()->with('profile_signature_status', __('Signature removed successfully.'));
        }

        Validator::make($request->all(), [
            'signature' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
        ])->validateWithBag('profileSignature');

        if ($user->signature_path) {
            Storage::disk('public')->delete($user->signature_path);
        }

        $path = $request->file('signature')->store('signatures', 'public');

        $user->forceFill(['signature_path' => $path])->save();

        return back()->with('profile_signature_status', __('Signature updated successfully.'));
    }
}
