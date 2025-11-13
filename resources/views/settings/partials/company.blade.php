<!-- Company Settings Content Loaded -->
<div class="intro-y box">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Building" class="w-5 h-5 mr-2 text-green-500" />
            Company Settings
        </h2>
        <x-base.button type="submit" form="companySettingsForm" variant="primary">
            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
            Save Changes
        </x-base.button>
    </div>

    <form id="companySettingsForm" action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data" class="p-5">
        @csrf
            
            <div class="grid grid-cols-12 gap-6">
                <!-- Company Name -->
                <div class="col-span-12 md:col-span-6">
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

                <!-- Logo -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="company_logo">
                        Company Logo
                    </x-base.form-label>
                    <x-base.form-input
                        id="company_logo"
                        name="logo"
                        type="file"
                        class="w-full"
                        accept="image/*"
                    />
                    @if($company && $company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="mt-2 h-16">
                    @endif
                </div>

                <!-- Address -->
                <div class="col-span-12">
                    <x-base.form-label for="company_address">
                        Address
                    </x-base.form-label>
                    <textarea
                        id="company_address"
                        name="address"
                        class="form-control w-full"
                        rows="3"
                        placeholder="Enter company address"
                    >{{ old('address', $company->address ?? '') }}</textarea>
                </div>

                <!-- Commercial Registration -->
                <div class="col-span-12 md:col-span-6">
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
                <div class="col-span-12 md:col-span-6">
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

                <!-- Phone -->
                <div class="col-span-12 md:col-span-6">
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
                <div class="col-span-12 md:col-span-6">
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
                <div class="col-span-12 md:col-span-6">
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

                <!-- Country -->
                <div class="col-span-12 md:col-span-6">
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
                <div class="col-span-12 md:col-span-6">
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
                <div class="col-span-12 md:col-span-6">
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
            </div>

            <div class="mt-5 flex justify-end">
                <x-base.button
                    type="submit"
                    variant="primary"
                    class="w-32"
                >
                    Save Company
                </x-base.button>
            </div>
        </form>
    </div>
</div>
