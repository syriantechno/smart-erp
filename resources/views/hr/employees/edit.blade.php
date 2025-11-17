@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Employee: {{ $employee->full_name }} - {{ config('app.name') }}</title>
@endsection

{{--
    Employee Edit View
    This view allows editing employee information
    @var \App\Models\Employee $employee
    @var \Illuminate\Database\Eloquent\Collection $departments
    @var \Illuminate\Database\Eloquent\Collection $companies
--}}

@section('subcontent')
<div class="content">
    <div class="intro-y mt-8 flex items-center">
        <h2 class="text-lg font-medium ml-3">Edit Employee: {{ $employee->full_name }}</h2>
        <x-base.button
            as="a"
            href="{{ route('hr.employees.show', $employee) }}"
            variant="outline-secondary"
            class="ml-auto"
        >
            <x-base.lucide icon="ArrowRight" class="w-4 h-4 ml-2" /> Back to Details
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="box p-5">
                <form action="{{ route('hr.employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-12 gap-4 gap-y-4">
                        <!-- Personal Information -->
                        <div class="col-span-12">
                            <h3 class="mb-4 border-b border-slate-200/60 pb-4 text-lg font-medium">Personal Information</h3>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="first_name">First Name <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input
                                id="first_name"
                                name="first_name"
                                type="text"
                                class="w-full"
                                value="{{ old('first_name', $employee->first_name) }}"
                                required
                            />
                            @error('first_name')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="middle_name">Middle Name</x-base.form-label>
                            <x-base.form-input
                                id="middle_name"
                                name="middle_name"
                                type="text"
                                class="w-full"
                                value="{{ old('middle_name', $employee->middle_name) }}"
                            />
                            @error('middle_name')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="last_name">Last Name <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input
                                id="last_name"
                                name="last_name"
                                type="text"
                                class="w-full"
                                value="{{ old('last_name', $employee->last_name) }}"
                                required
                            />
                            @error('last_name')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="birth_date">Date of Birth</x-base.form-label>
                            <div class="relative w-full">
                                <div
                                    class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                    <x-base.lucide icon="Calendar" class="h-5 w-5 stroke-1.5" />
                                </div>
                                <x-base.litepicker
                                    id="birth_date"
                                    name="birth_date"
                                    class="pl-12"
                                    data-single-mode="true"
                                    value="{{ old('birth_date', optional($employee->birth_date)->format('Y-m-d')) }}"
                                />
                            </div>
                            @error('birth_date')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="gender">Gender</x-base.form-label>
                            <x-base.form-select id="gender" name="gender" class="w-full">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </x-base.form-select>
                            @error('gender')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="photo">Profile Photo</x-base.form-label>
                            <input
                                id="photo"
                                name="photo"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-primary/5 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/10"
                            >
                            @if($employee->photo_url)
                                <div class="mt-2">
                                    <img src="{{ $employee->photo_url }}" alt="صورة الموظف" class="h-20 w-20 rounded-full object-cover">
                                </div>
                            @endif
                            @error('photo')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-span-12 mt-6">
                            <h3 class="mb-4 border-b border-slate-200/60 pb-4 text-lg font-medium">Contact Information</h3>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="email">Email <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input
                                id="email"
                                name="email"
                                type="email"
                                class="w-full"
                                value="{{ old('email', $employee->email) }}"
                                required
                            />
                            @error('email')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="phone">Mobile Number</x-base.form-label>
                            <x-base.form-input
                                id="phone"
                                name="phone"
                                type="tel"
                                class="w-full"
                                value="{{ old('phone', $employee->phone) }}"
                            />
                            @error('phone')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12">
                            <x-base.form-label for="address">Address</x-base.form-label>
                            <x-base.form-textarea
                                id="address"
                                name="address"
                                rows="2"
                                class="w-full"
                            >{{ old('address', $employee->address) }}</x-base.form-textarea>
                            @error('address')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="city">City</x-base.form-label>
                            <x-base.form-input
                                id="city"
                                name="city"
                                type="text"
                                class="w-full"
                                value="{{ old('city', $employee->city) }}"
                            />
                            @error('city')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="country">Country</x-base.form-label>
                            <x-base.form-input
                                id="country"
                                name="country"
                                type="text"
                                class="w-full"
                                value="{{ old('country', $employee->country ?? 'Saudi Arabia') }}"
                            />
                            @error('country')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="postal_code">Postal Code</x-base.form-label>
                            <x-base.form-input
                                id="postal_code"
                                name="postal_code"
                                type="text"
                                class="w-full"
                                value="{{ old('postal_code', $employee->postal_code) }}"
                            />
                            @error('postal_code')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Employment Information -->
                        <div class="col-span-12 mt-6">
                            <h3 class="mb-4 border-b border-slate-200/60 pb-4 text-lg font-medium">Employment Information</h3>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="employee_id">Employee Code</x-base.form-label>
                            <x-base.form-input
                                id="employee_id"
                                name="employee_id"
                                type="text"
                                class="w-full"
                                value="{{ old('employee_id', $employee->employee_id) }}"
                                readonly
                            />
                            <div class="mt-1 text-xs text-slate-500">Employee code cannot be changed.</div>
                            @error('employee_id')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="position">Position <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input
                                id="position"
                                name="position"
                                type="text"
                                class="w-full"
                                value="{{ old('position', $employee->position) }}"
                                required
                            />
                            @error('position')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="department_id">Department <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="department_id" name="department_id" class="w-full" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            @error('department_id')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            @error('company_id')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="hire_date">Hire Date <span class="text-danger">*</span></x-base.form-label>
                            <div class="relative w-full">
                                <div
                                    class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                    <x-base.lucide icon="Calendar" class="h-5 w-5 stroke-1.5" />
                                </div>
                                <x-base.litepicker
                                    id="hire_date"
                                    name="hire_date"
                                    class="pl-12"
                                    data-single-mode="true"
                                    value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}"
                                    required
                                />
                            </div>
                            @error('hire_date')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="salary">Basic Salary <span class="text-danger">*</span></x-base.form-label>
                            <div class="flex items-center gap-2">
                                <x-base.form-input
                                    id="salary"
                                    name="salary"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full"
                                    value="{{ old('salary', $employee->salary) }}"
                                    required
                                />
                                <span class="text-sm text-slate-500">{{ setting('currency.symbol', config('app.currency', 'USD')) }}</span>
                            </div>
                            @error('salary')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-12 mt-3">
                            <div class="flex items-center gap-2">
                                <input
                                    id="is_active"
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                                    {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                                >
                                <label for="is_active" class="text-sm">Active Account</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end gap-2">
                        <x-base.button
                            as="a"
                            href="{{ route('hr.employees.show', $employee) }}"
                            variant="outline-secondary"
                            class="w-24"
                        >
                            <x-base.lucide icon="X" class="w-4 h-4 mr-2 animate-pulse" />
                            Cancel
                        </x-base.button>
                        <x-base.button
                            type="submit"
                            variant="primary"
                            class="w-32"
                        >
                            <x-base.lucide icon="Save" class="w-4 h-4 mr-2 animate-pulse" />
                            Save Changes
                        </x-base.button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-span-12 lg:col-span-4">
            <div class="intro-y box p-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">Profile Picture</h2>
                    <div class="mt-1 text-xs text-slate-500">Maximum file size 2 MB. Allowed types: jpg, jpeg, png.</div>
                </div>
                
                <div class="border-2 border-dashed rounded-md p-5 text-center">
                    <div id="image-preview" class="mx-auto mb-4 h-40 w-40 overflow-hidden rounded-full bg-slate-100">
                        <img id="preview-image" 
                             src="{{ $employee->photo_url ?? asset('dist/images/profile-1.jpg') }}" 
                             alt="Profile photo" 
                             class="h-full w-full object-cover">
                    </div>
                    <div class="mt-2 text-xs text-slate-500">Click to upload a new photo</div>
                </div>
            </div>
            
            @if($employee->user)
            <div class="intro-y box p-5 mt-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">User Account</h2>
                    <div class="mt-1 text-xs text-slate-500">Manage the user account linked to this employee.</div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-slate-500">Username</div>
                        <div class="font-medium">{{ $employee->user->name }}</div>
                    </div>
                    
                    <div>
                        <div class="text-xs text-slate-500">Email</div>
                        <div class="font-medium">{{ $employee->user->email }}</div>
                    </div>
                    
                    <div>
                        <div class="text-xs text-slate-500">Account Status</div>
                        <div class="font-medium">
                            <span class="px-2 py-1 text-xs rounded-full {{ $employee->user->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                {{ $employee->user->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="pt-4 mt-4 border-t border-slate-200/60">
                        @if (app('router')->has('users.edit'))
                            <a href="{{ route('users.edit', $employee->user) }}" class="btn btn-outline-primary w-full">
                            <i data-lucide="edit-3" class="w-4 h-4 ml-2"></i> Edit User Account
                            </a>
                        @else
                            <button type="button" class="btn btn-outline-secondary w-full" disabled>
                                <i data-lucide="info" class="w-4 h-4 ml-2"></i> User account management is not enabled yet
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="intro-y box p-5 mt-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">Create User Account</h2>
                    <div class="mt-1 text-xs text-slate-500">You can create a user account for this employee.</div>
                </div>
                
                @if (app('router')->has('users.create'))
                    <a href="{{ route('users.create', ['employee_id' => $employee->id]) }}" class="btn btn-primary w-full">
                        <i data-lucide="user-plus" class="w-4 h-4 ml-2"></i> Create User Account
                    </a>
                @else
                    <button type="button" class="btn btn-primary w-full" disabled>
                        <i data-lucide="user-plus" class="w-4 h-4 ml-2 animate-pulse"></i> Create User Account (not configured yet)
                    </button>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    /**
     * Initialize employee form functionality
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Handle image preview functionality
        const photoInput = document.getElementById('photo');
        const previewImage = document.getElementById('preview-image');
        
        if (photoInput && previewImage) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Auto-generate email if empty
        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.value) {
            const firstName = document.getElementById('first_name')?.value.toLowerCase() || '';
            const lastName = document.getElementById('last_name')?.value.toLowerCase() || '';
            if (firstName && lastName) {
                emailInput.value = `${firstName}.${lastName}@example.com`;
            }
        }

        // Initialize select2 if used
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select2').select2({
                theme: 'tailwind',
                width: '100%',
                placeholder: 'Select an option'
            });
        }
    });
</script>
@endpush
@endsection
