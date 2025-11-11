<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PrefixSetting;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        $prefixSettings = PrefixSetting::all();
        $company = Company::first();
        
        return view('settings.index', [
            'unified_code' => $settings['unified_code'] ?? '',
            'prefixSettings' => $prefixSettings,
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'unified_code' => 'required|string|max:255',
        ]);

        Setting::set('unified_code', $request->unified_code, 'text', 'Unified Code for the system');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }

    public function updatePrefix(Request $request)
    {
        $request->validate([
            'prefixes' => 'required|array',
            'prefixes.*.prefix' => 'required|string|max:10',
            'prefixes.*.padding' => 'required|integer|min:1|max:10',
            'prefixes.*.start_number' => 'required|integer|min:1',
            'prefixes.*.include_year' => 'boolean',
        ]);

        foreach ($request->prefixes as $id => $data) {
            PrefixSetting::where('id', $id)->update([
                'prefix' => $data['prefix'],
                'padding' => $data['padding'],
                'start_number' => $data['start_number'],
                'current_number' => $data['start_number'],
                'include_year' => isset($data['include_year']) ? true : false,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Prefix settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Prefix settings updated successfully!');
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'commercial_registration' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ]);

        $company = Company::first();
        
        $data = $request->except('logo');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('companies', 'public');
            $data['logo'] = $logoPath;
            
            // Delete old logo if exists
            if ($company && $company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }
        }

        if ($company) {
            $company->update($data);
        } else {
            Company::create($data);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Company settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Company settings updated successfully!');
    }
}
