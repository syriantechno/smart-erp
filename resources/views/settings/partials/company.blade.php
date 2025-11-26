<!-- Company Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Building" class="w-5 h-5 mr-2 text-green-500" />
            Company Settings
        </h2>
    </div>

    <form id="companySettingsForm" action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data" class="p-5">
        @csrf

        @php
            $logoUrl = ($company && $company->logo) ? asset('storage/' . $company->logo) : null;
        @endphp

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="grid grid-cols-12 gap-5">
                    <!-- Company Name -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_name">
                            Company Name <span class="text-danger">*</span>
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Enter company name"
                            value="{{ old('name', $company->name ?? '') }}"
                            required
                        />
                    </div>

                    <!-- Phone -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_phone">
                            Phone
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_phone"
                            name="phone"
                            type="tel"
                            class="w-full"
                            placeholder="Enter phone number"
                            value="{{ old('phone', $company->phone ?? '') }}"
                        />
                    </div>

                    <!-- Email -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_email">
                            Email
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_email"
                            name="email"
                            type="email"
                            class="w-full"
                            placeholder="Enter email address"
                            value="{{ old('email', $company->email ?? '') }}"
                        />
                    </div>

                    <!-- Website -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_website">
                            Website
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_website"
                            name="website"
                            type="url"
                            class="w-full"
                            placeholder="https://example.com"
                            value="{{ old('website', $company->website ?? '') }}"
                        />
                    </div>

                    <!-- Commercial Registration -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="commercial_registration">
                            Commercial Registration
                        </x-base.form-label>
                        <x-base.form-input
                            id="commercial_registration"
                            name="commercial_registration"
                            type="text"
                            class="w-full"
                            placeholder="Enter commercial registration number"
                            value="{{ old('commercial_registration', $company->commercial_registration ?? '') }}"
                        />
                    </div>

                    <!-- Tax Number -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="tax_number">
                            Tax Number
                        </x-base.form-label>
                        <x-base.form-input
                            id="tax_number"
                            name="tax_number"
                            type="text"
                            class="w-full"
                            placeholder="Enter tax number"
                            value="{{ old('tax_number', $company->tax_number ?? '') }}"
                        />
                    </div>

                    <!-- Country -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_country">
                            Country
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_country"
                            name="country"
                            type="text"
                            class="w-full"
                            placeholder="Enter country"
                            value="{{ old('country', $company->country ?? '') }}"
                        />
                    </div>

                    <!-- City -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="company_city">
                            City
                        </x-base.form-label>
                        <x-base.form-input
                            id="company_city"
                            name="city"
                            type="text"
                            class="w-full"
                            placeholder="Enter city"
                            value="{{ old('city', $company->city ?? '') }}"
                        />
                    </div>

                    <!-- Postal Code -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="postal_code">
                            Postal Code
                        </x-base.form-label>
                        <x-base.form-input
                            id="postal_code"
                            name="postal_code"
                            type="text"
                            class="w-full"
                            placeholder="Enter postal code"
                            value="{{ old('postal_code', $company->postal_code ?? '') }}"
                        />
                    </div>

                    <!-- Address -->
                    <div class="col-span-12 lg:col-span-8">
                        <x-base.form-label for="company_address">
                            Address
                        </x-base.form-label>
                        <x-base.form-textarea
                            id="company_address"
                            name="address"
                            rows="3"
                            class="form-control w-full resize-none text-sm focus:ring-2 focus:ring-primary/40 dark:bg-darkmode-600"
                            placeholder="Enter company address"
                        >{{ old('address', $company->address ?? '') }}</x-base.form-textarea>
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="col-span-12 lg:col-span-4">
                <x-base.form-label for="company_logo" class="flex items-center justify-between">
                    <span>Company Logo</span>
                    <span class="text-xs font-medium text-slate-400">PNG, JPG • Max 2MB</span>
                </x-base.form-label>
                <div
                    class="relative flex flex-col items-center gap-4 rounded-2xl border border-dashed border-slate-200/80 bg-slate-50/70 px-5 py-6 text-center shadow-sm transition hover:border-primary/60 dark:border-darkmode-400 dark:bg-darkmode-600/40"
                >
                    <div class="flex flex-col items-center" data-default-logo="{{ $logoUrl }}">
                        <img
                            id="company-logo-preview"
                            data-initial-src="{{ $logoUrl }}"
                            src="{{ $logoUrl }}"
                            class="h-24 w-24 rounded-2xl object-cover shadow {{ $logoUrl ? '' : 'hidden' }}"
                            alt="Company Logo Preview"
                        >
                        <div
                            id="company-logo-placeholder"
                            class="flex h-24 w-24 items-center justify-center rounded-2xl bg-white shadow-inner dark:bg-darkmode-500 {{ $logoUrl ? 'hidden' : '' }}"
                        >
                            <x-base.lucide icon="Image" class="h-8 w-8 text-slate-400" />
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Upload a square logo</p>
                        <p class="text-xs text-slate-500">Best fit: transparent background, 256×256px</p>
                    </div>

                    <div class="flex w-full flex-col gap-2">
                        <label
                            for="company_logo"
                            class="inline-flex w-full items-center justify-center rounded-lg border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20"
                        >
                            <x-base.lucide icon="UploadCloud" class="mr-2 h-4 w-4" />
                            Choose Logo
                        </label>
                        <button
                            type="button"
                            id="company-logo-reset"
                            class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-darkmode-400 dark:text-slate-300"
                        >
                            <x-base.lucide icon="RotateCcw" class="mr-2 h-4 w-4" />
                            Reset Selection
                        </button>
                    </div>

                    <input
                        id="company_logo"
                        name="logo"
                        type="file"
                        class="sr-only"
                        accept="image/*"
                    />
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-32">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save
            </button>
        </div>
    </form>
</div>

@php $companyCollection = $companies ?? collect(); @endphp

<div class="mt-8 hidden" id="company-table-section">
    <div class="intro-y box">
        <div class="flex flex-col gap-3 border-b border-slate-200/60 p-5 dark:border-darkmode-400 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-base font-semibold text-slate-800 dark:text-slate-100">Available Companies</p>
                <p class="text-sm text-slate-500">Overview of all configured companies with quick actions.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-auto" id="company-table-export">
                    <x-base.lucide icon="download" class="w-4 h-4 mr-2" />
                    Export
                </button>
                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-auto" id="company-table-refresh">
                    <x-base.lucide icon="refresh-ccw" class="w-4 h-4 mr-2" />
                    Refresh
                </button>
            </div>
        </div>

        <div class="p-5">
            <div class="overflow-x-auto">
                <table id="settings-company-table" class="w-full min-w-full table-auto text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center font-semibold text-xs uppercase tracking-wide text-slate-500">#</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500">Company</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500">Commercial / Tax</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500">Contact</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500">Location</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500 text-center">Status</th>
                            <th class="px-4 py-2 font-semibold text-xs uppercase tracking-wide text-slate-500 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companyCollection as $companyRow)
                            @php
                                $payload = [
                                    'name' => $companyRow->name,
                                    'address' => $companyRow->address,
                                    'commercial_registration' => $companyRow->commercial_registration,
                                    'tax_number' => $companyRow->tax_number,
                                    'phone' => $companyRow->phone,
                                    'email' => $companyRow->email,
                                    'website' => $companyRow->website,
                                    'country' => $companyRow->country,
                                    'city' => $companyRow->city,
                                    'postal_code' => $companyRow->postal_code,
                                ];
                            @endphp
                            <tr class="border-b border-slate-200/60 dark:border-darkmode-400/60 last:border-b-0">
                                <td class="px-4 py-3 text-center text-sm text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $companyRow->name }}</div>
                                    <div class="text-xs text-slate-500 break-all">{{ $companyRow->website ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    <div><span class="text-xs uppercase text-slate-500">CR</span>: {{ $companyRow->commercial_registration ?? '—' }}</div>
                                    <div><span class="text-xs uppercase text-slate-500">Tax</span>: {{ $companyRow->tax_number ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    <div>{{ $companyRow->phone ?? '—' }}</div>
                                    <div class="text-xs text-slate-500 break-all">{{ $companyRow->email ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    <div>{{ $companyRow->city ?? '—' }}, {{ $companyRow->country ?? '—' }}</div>
                                    <div class="text-xs text-slate-500">{{ $companyRow->postal_code ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($companyRow->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <button type="button" class="btn-royal btn-royal--action btn-royal--primary company-load-btn" data-company='@json($payload)'>
                                            <x-base.lucide icon="edit-3" class="w-3.5 h-3.5 mr-1" /> Load
                                        </button>
                                        @if($companyRow->website)
                                            <a
                                                href="{{ $companyRow->website }}"
                                                target="_blank"
                                                rel="noopener"
                                                class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-darkmode-400 dark:text-slate-300"
                                            >
                                                <x-base.lucide icon="ExternalLink" class="w-3.5 h-3.5 mr-1" /> Visit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">No companies available yet. Use the form above to add one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
